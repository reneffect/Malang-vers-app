using System;
using System.Collections.Generic;
using System.Drawing;
using System.Drawing.Drawing2D;
using System.Drawing.Imaging;
using System.Drawing.Printing;
using System.IO;
using System.Linq;
using System.Windows.Forms;

namespace dekstop
{
    public partial class ReceiptDetailForm : Form
    {
        private readonly string transaksiId;
        private TransaksiSummaryModel currentTrx;
        private List<TransaksiDetailItemModel> currentItems = new List<TransaksiDetailItemModel>();



        private float zoomFactor = 1.0f;
        private const int BasePaperWidth = 420;

        public ReceiptDetailForm() : this(null)
        {
        }

        public ReceiptDetailForm(string trxId)
        {
            transaksiId = trxId;
            LoadReceiptData();
            InitializeComponent();
            LayoutReceiptPaper();
        }

        private void LoadReceiptData()
        {
            if (string.IsNullOrWhiteSpace(transaksiId) || DatabaseService.IsDesignMode())
            {
                currentTrx = new TransaksiSummaryModel
                {
                    TransaksiId = "ORD-2026-0891",
                    UserNama = "Bagus Wicaksono",
                    TransaksiTanggal = DateTime.Now,
                    PembayaranTanggal = DateTime.Now,
                    TransaksiTotal = 85000m,
                    TransaksiDiskon = 0m,
                    TransaksiGrandtotal = 85000m,
                    TransaksiStatus = "Success",
                    MetodePembayaran = "QRIS",
                    PembayaranReferensi = "QRIS-MV-0988129031"
                };
                currentItems = new List<TransaksiDetailItemModel>
                {
                    new TransaksiDetailItemModel
                    {
                        EbookJudul = "Kamus Bahasa Walikan Malang v2",
                        EbookStatusAkses = "PDF + EPUB",
                        DetailHarga = 85000m,
                        DetailQty = 1,
                        DetailSubtotal = 85000m
                    }
                };
                return;
            }

            try
            {
                currentTrx = DatabaseService.GetTransactions(transaksiId, "Semua Status")
                    .FirstOrDefault(t => t.TransaksiId.Equals(transaksiId, StringComparison.OrdinalIgnoreCase));
                currentItems = DatabaseService.GetTransactionDetails(transaksiId);
            }
            catch (Exception ex)
            {
                MessageBox.Show("Gagal memuat detail struk:\n" + ex.Message,
                    "Kesalahan Database", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }

            if (currentTrx == null)
            {
                currentTrx = new TransaksiSummaryModel
                {
                    TransaksiId = transaksiId ?? "ORD-0000",
                    UserNama = "-",
                    TransaksiTanggal = DateTime.Now,
                    TransaksiStatus = "Pending",
                    MetodePembayaran = "QRIS"
                };
            }
        }



        private void SavePdfButton_Click(object sender, EventArgs e)
        {
            SaveReceiptAsPdfOrImage();
        }

        private void ZoomInButton_Click(object sender, EventArgs e)
        {
            ChangeZoom(0.10f);
        }

        private void ZoomOutButton_Click(object sender, EventArgs e)
        {
            ChangeZoom(-0.10f);
        }

        private void PrintNowButton_Click(object sender, EventArgs e)
        {
            PrintReceipt();
        }

        private void CloseButton_Click(object sender, EventArgs e)
        {
            Close();
        }

        private void ViewerCanvas_Resize(object sender, EventArgs e)
        {
            LayoutReceiptPaper();
        }

        private void TopBar_Paint(object sender, PaintEventArgs e)
        {
            using (Pen pen = new Pen(Color.FromArgb(226, 232, 240)))
                e.Graphics.DrawLine(pen, 0, topBar.Height - 1, topBar.Width, topBar.Height - 1);
        }

        private void BottomBar_Paint(object sender, PaintEventArgs e)
        {
            using (Pen pen = new Pen(Color.FromArgb(226, 232, 240)))
                e.Graphics.DrawLine(pen, 0, 0, bottomBar.Width, 0);
        }

        private sealed class DoubleBufferedPanel : Panel
        {
            public DoubleBufferedPanel()
            {
                DoubleBuffered = true;
                ResizeRedraw = true;
            }
        }

        private int CalculateBasePaperHeight()
        {
            int itemCount = Math.Max(1, currentItems.Count);
            int extraItemsHeight = (itemCount - 1) * 48;
            int discountExtra = (currentTrx != null && currentTrx.TransaksiDiskon > 0) ? 18 : 0;
            return 752 + extraItemsHeight + discountExtra;
        }

        private void ChangeZoom(float delta)
        {
            zoomFactor = Math.Max(0.70f, Math.Min(1.50f, zoomFactor + delta));
            zoomPercentLabel.Text = $"{Math.Round(zoomFactor * 100)}%";
            LayoutReceiptPaper();
        }

        private void LayoutReceiptPaper()
        {
            if (paperContainer == null || viewerCanvas == null) return;
            int baseH = CalculateBasePaperHeight();
            int scaledW = (int)Math.Round(BasePaperWidth * zoomFactor);
            int scaledH = (int)Math.Round(baseH * zoomFactor);

            paperContainer.Size = new Size(scaledW, scaledH);

            int pad = 26;
            int left = Math.Max(pad, (viewerCanvas.ClientSize.Width - scaledW) / 2);
            int top = Math.Max(pad, (viewerCanvas.ClientSize.Height - scaledH) / 2);

            paperContainer.Location = new Point(
                left - viewerCanvas.HorizontalScroll.Value,
                top - viewerCanvas.VerticalScroll.Value);
            paperContainer.Invalidate();
        }

        private void PaperContainer_Paint(object sender, PaintEventArgs e)
        {
            Graphics g = e.Graphics;
            g.SmoothingMode = SmoothingMode.AntiAlias;
            g.TextRenderingHint = System.Drawing.Text.TextRenderingHint.ClearTypeGridFit;
            g.ScaleTransform(zoomFactor, zoomFactor);

            int baseH = CalculateBasePaperHeight();
            DrawReceiptSheet(g, BasePaperWidth, baseH);
        }

        private void DrawReceiptSheet(Graphics g, int width, int height)
        {
            g.FillRectangle(Brushes.White, 0, 0, width, height);
            using (Pen borderPen = new Pen(Color.FromArgb(203, 213, 225), 1f))
            {
                g.DrawRectangle(borderPen, 0, 0, width - 1, height - 1);
            }

            int padX = 28;
            int contentW = width - (padX * 2);
            float y = 24f;

            // Colors & Fonts
            Color darkText = Color.FromArgb(15, 23, 42);
            Color bodyText = Color.FromArgb(51, 65, 85);
            Color mutedText = Color.FromArgb(100, 116, 139);
            Color blueAccent = Color.FromArgb(29, 78, 216);

            using (Font logoFont = new Font("Segoe UI", 10F, FontStyle.Bold))
            using (Font brandFont = new Font("Consolas", 10.5F, FontStyle.Bold))
            using (Font subHeaderFont = new Font("Consolas", 7.6F, FontStyle.Regular))
            using (Font rowLabelFont = new Font("Consolas", 8F, FontStyle.Regular))
            using (Font rowBoldFont = new Font("Consolas", 8F, FontStyle.Bold))
            using (Font itemItalicFont = new Font("Consolas", 7.4F, FontStyle.Italic))
            using (Font totalLabelFont = new Font("Consolas", 8.8F, FontStyle.Bold))
            using (Font totalValFont = new Font("Consolas", 11F, FontStyle.Bold))
            using (Font badgeFont = new Font("Consolas", 7.6F, FontStyle.Bold))
            using (Font licenseHeaderFont = new Font("Consolas", 7.5F, FontStyle.Bold))
            using (Font licenseCodeFont = new Font("Consolas", 9F, FontStyle.Bold))
            using (Font footerFont = new Font("Consolas", 7.1F, FontStyle.Regular))
            using (Brush darkBrush = new SolidBrush(darkText))
            using (Brush bodyBrush = new SolidBrush(bodyText))
            using (Brush mutedBrush = new SolidBrush(mutedText))
            using (Brush blueBrush = new SolidBrush(blueAccent))
            using (Pen dashPen = new Pen(Color.FromArgb(148, 163, 184), 1f) { DashStyle = DashStyle.Dash })
            {
                StringFormat centerFmt = new StringFormat { Alignment = StringAlignment.Center, LineAlignment = StringAlignment.Center };
                StringFormat leftFmt = new StringFormat { Alignment = StringAlignment.Near, LineAlignment = StringAlignment.Near };
                StringFormat rightFmt = new StringFormat { Alignment = StringAlignment.Far, LineAlignment = StringAlignment.Near };

                // 1. Logo MV Badge
                int badgeSize = 36;
                RectangleF mvRect = new RectangleF((width - badgeSize) / 2f, y, badgeSize, badgeSize);
                using (GraphicsPath path = CreateRoundedRect(mvRect, 6f))
                using (SolidBrush darkBadge = new SolidBrush(Color.FromArgb(30, 41, 59)))
                {
                    g.FillPath(darkBadge, path);
                }
                g.DrawString("MV", logoFont, Brushes.White, mvRect, centerFmt);
                y += badgeSize + 10;

                // 2. Company Header
                g.DrawString("MALANGVERSE DIGITAL PLATFORM", brandFont, darkBrush, new RectangleF(padX, y, contentW, 18), centerFmt);
                y += 19;
                g.DrawString("PT. Kreasi Digital Arema Malang", subHeaderFont, mutedBrush, new RectangleF(padX, y, contentW, 14), centerFmt);
                y += 14;
                g.DrawString("Jl. Ijen No. 45, Kota Malang, Jawa Timur", subHeaderFont, mutedBrush, new RectangleF(padX, y, contentW, 14), centerFmt);
                y += 14;
                g.DrawString("Telp: (0341) 555-890 | NPWP: 82.411.902.1-652.000", subHeaderFont, mutedBrush, new RectangleF(padX, y, contentW, 14), centerFmt);
                y += 22;

                g.DrawLine(dashPen, padX, y, width - padX, y);
                y += 12;

                // 3. Transaction Metadata
                string trxCode = currentTrx?.TransaksiId ?? "ORD-2026-0891";
                string kwtCode = "KWT-" + trxCode.Replace("ORD-", "");
                DateTime payTime = currentTrx?.PembayaranTanggal ?? currentTrx?.TransaksiTanggal ?? DateTime.Now;
                string kasirName = string.IsNullOrWhiteSpace(UserSession.Nama) ? "Kasir POS" : UserSession.Nama;
                string customerName = string.IsNullOrWhiteSpace(currentTrx?.UserNama) ? "Pelanggan Umum" : currentTrx.UserNama;
                string contactInfo = ExtractContactInfo(currentTrx?.PembayaranReferensi);

                DrawKeyValueRow(g, padX, contentW, ref y, "No. Kwitansi", kwtCode, rowLabelFont, rowBoldFont, bodyBrush, darkBrush, leftFmt, rightFmt);
                DrawKeyValueRow(g, padX, contentW, ref y, "ID Transaksi", trxCode, rowLabelFont, rowLabelFont, bodyBrush, bodyBrush, leftFmt, rightFmt);
                DrawKeyValueRow(g, padX, contentW, ref y, "Waktu Pembayaran", payTime.ToString("dd MMM yyyy HH:mm") + " WIB", rowLabelFont, rowLabelFont, bodyBrush, bodyBrush, leftFmt, rightFmt);
                DrawKeyValueRow(g, padX, contentW, ref y, "Nama Kasir", kasirName + " (Terminal 01)", rowLabelFont, rowLabelFont, bodyBrush, bodyBrush, leftFmt, rightFmt);
                DrawKeyValueRow(g, padX, contentW, ref y, "Pelanggan", customerName, rowLabelFont, rowBoldFont, bodyBrush, darkBrush, leftFmt, rightFmt);
                DrawKeyValueRow(g, padX, contentW, ref y, "No. WhatsApp / Kontak", contactInfo, rowLabelFont, rowLabelFont, bodyBrush, bodyBrush, leftFmt, rightFmt);

                y += 4;
                g.DrawLine(dashPen, padX, y, width - padX, y);
                y += 12;

                // 4. Items Header
                g.DrawString("Item & Deskripsi", rowBoldFont, darkBrush, new RectangleF(padX, y, contentW * 0.65f, 16), leftFmt);
                g.DrawString("Jumlah (Rp)", rowBoldFont, darkBrush, new RectangleF(padX, y, contentW, 16), rightFmt);
                y += 22;

                // 5. Purchased E-Book Items
                var itemsToDraw = (currentItems != null && currentItems.Count > 0)
                    ? currentItems
                    : new List<TransaksiDetailItemModel>
                    {
                        new TransaksiDetailItemModel
                        {
                            EbookJudul = "Kamus Bahasa Walikan Malang v2",
                            EbookStatusAkses = "PDF + EPUB",
                            DetailHarga = currentTrx?.TransaksiGrandtotal ?? 85000m,
                            DetailQty = 1,
                            DetailSubtotal = currentTrx?.TransaksiGrandtotal ?? 85000m
                        }
                    };

                foreach (var item in itemsToDraw)
                {
                    g.DrawString(item.EbookJudul, rowBoldFont, darkBrush, new RectangleF(padX, y, contentW, 16), leftFmt);
                    y += 15;
                    string formatLabel = string.IsNullOrWhiteSpace(item.EbookStatusAkses) ? "PDF + EPUB" : item.EbookStatusAkses;
                    g.DrawString($"Edisi Lengkap Digital E-Book ({formatLabel})", itemItalicFont, mutedBrush, new RectangleF(padX, y, contentW, 15), leftFmt);
                    y += 15;
                    g.DrawString($"{item.DetailQty} x {DatabaseService.FormatRupiah(item.DetailHarga)}", rowLabelFont, bodyBrush, new RectangleF(padX, y, contentW * 0.65f, 16), leftFmt);
                    g.DrawString($"{item.DetailSubtotal:N0}", rowBoldFont, darkBrush, new RectangleF(padX, y, contentW, 16), rightFmt);
                    y += 20;
                }

                g.DrawLine(dashPen, padX, y, width - padX, y);
                y += 12;

                // 6. Totals Summary
                decimal subtotalVal = currentTrx?.TransaksiTotal ?? itemsToDraw.Sum(i => i.DetailSubtotal);
                decimal diskonVal = currentTrx?.TransaksiDiskon ?? 0m;
                decimal grandTotalVal = currentTrx?.TransaksiGrandtotal ?? Math.Max(0m, subtotalVal - diskonVal);
                decimal ppnIncluded = Math.Round(grandTotalVal * 11m / 111m, 0);

                DrawKeyValueRow(g, padX, contentW, ref y, "Subtotal Item", DatabaseService.FormatRupiah(subtotalVal), rowLabelFont, rowLabelFont, bodyBrush, bodyBrush, leftFmt, rightFmt);
                if (diskonVal > 0)
                {
                    DrawKeyValueRow(g, padX, contentW, ref y, "Diskon / Potongan", "-" + DatabaseService.FormatRupiah(diskonVal), rowLabelFont, rowBoldFont, bodyBrush, darkBrush, leftFmt, rightFmt);
                }
                DrawKeyValueRow(g, padX, contentW, ref y, "Biaya Layanan Gerbang Pembayaran", "Rp 0", rowLabelFont, rowLabelFont, bodyBrush, bodyBrush, leftFmt, rightFmt);
                DrawKeyValueRow(g, padX, contentW, ref y, "PPN 11% (Termasuk)", $"({DatabaseService.FormatRupiah(ppnIncluded)})", rowLabelFont, rowLabelFont, mutedBrush, mutedBrush, leftFmt, rightFmt);

                y += 4;
                g.DrawString("TOTAL PEMBAYARAN", totalLabelFont, darkBrush, new RectangleF(padX, y + 2, contentW * 0.55f, 20), leftFmt);
                g.DrawString(DatabaseService.FormatRupiah(grandTotalVal), totalValFont, darkBrush, new RectangleF(padX, y, contentW, 22), rightFmt);
                y += 28;

                // 7. Payment Box
                RectangleF payBox = new RectangleF(padX, y, contentW, 74);
                using (SolidBrush boxBg = new SolidBrush(Color.FromArgb(248, 250, 252)))
                using (Pen boxBorder = new Pen(Color.FromArgb(226, 232, 240)))
                {
                    g.FillRectangle(boxBg, payBox);
                    g.DrawRectangle(boxBorder, payBox.X, payBox.Y, payBox.Width, payBox.Height);
                }

                float py = y + 9;
                string metode = string.IsNullOrWhiteSpace(currentTrx?.MetodePembayaran) ? "QRIS" : currentTrx.MetodePembayaran;
                g.DrawString("Metode Bayar:", rowLabelFont, mutedBrush, new RectangleF(padX + 10, py, 140, 16), leftFmt);
                g.DrawString(metode, rowBoldFont, darkBrush, new RectangleF(padX + 10, py, contentW - 20, 16), rightFmt);
                py += 20;

                g.DrawString("Status Pembayaran:", rowLabelFont, mutedBrush, new RectangleF(padX + 10, py + 2, 150, 16), leftFmt);

                string rawStatus = currentTrx?.TransaksiStatus ?? "Success";
                string statusPillText = "LUNAS (PAID)";
                Color pillFill = Color.FromArgb(220, 252, 231);
                Color pillBorder = Color.FromArgb(74, 222, 128);
                Color pillTextCol = Color.FromArgb(21, 128, 61);

                if (rawStatus.Equals("Pending", StringComparison.OrdinalIgnoreCase))
                {
                    statusPillText = "MENUNGGU (PENDING)";
                    pillFill = Color.FromArgb(254, 243, 199);
                    pillBorder = Color.FromArgb(251, 191, 36);
                    pillTextCol = Color.FromArgb(180, 83, 9);
                }
                else if (rawStatus.Equals("Canceled", StringComparison.OrdinalIgnoreCase))
                {
                    statusPillText = "DIBATALKAN";
                    pillFill = Color.FromArgb(254, 226, 226);
                    pillBorder = Color.FromArgb(248, 113, 113);
                    pillTextCol = Color.FromArgb(185, 28, 28);
                }

                SizeF pillSize = g.MeasureString(statusPillText, badgeFont);
                float pillW = pillSize.Width + 14;
                RectangleF pillRect = new RectangleF(padX + contentW - 10 - pillW, py - 1, pillW, 19);
                using (SolidBrush pFill = new SolidBrush(pillFill))
                using (Pen pBorder = new Pen(pillBorder))
                using (SolidBrush pText = new SolidBrush(pillTextCol))
                {
                    g.FillRectangle(pFill, pillRect);
                    g.DrawRectangle(pBorder, pillRect.X, pillRect.Y, pillRect.Width, pillRect.Height);
                    g.DrawString(statusPillText, badgeFont, pText, pillRect, centerFmt);
                }
                py += 22;

                string refCode = BuildPaymentReference(currentTrx);
                g.DrawString("Ref QRIS / Transaksi:", rowLabelFont, mutedBrush, new RectangleF(padX + 10, py, 165, 16), leftFmt);
                g.DrawString(refCode, rowLabelFont, bodyBrush, new RectangleF(padX + 10, py, contentW - 20, 16), rightFmt);

                y += 86;
                g.DrawLine(dashPen, padX, y, width - padX, y);
                y += 12;

                // 8. Digital License Activation Code
                g.DrawString("KODE AKTIVASI LISENSI DIGITAL", licenseHeaderFont, bodyBrush, new RectangleF(padX, y, contentW, 15), centerFmt);
                y += 18;

                string licenseCode = BuildLicenseCode(trxCode);
                float licW = 240f;
                RectangleF licRect = new RectangleF((width - licW) / 2f, y, licW, 28);
                using (SolidBrush licBg = new SolidBrush(Color.FromArgb(241, 245, 249)))
                using (Pen licBorder = new Pen(Color.FromArgb(203, 213, 225)))
                {
                    g.FillRectangle(licBg, licRect);
                    g.DrawRectangle(licBorder, licRect.X, licRect.Y, licRect.Width, licRect.Height);
                }
                g.DrawString(licenseCode, licenseCodeFont, blueBrush, licRect, centerFmt);
                y += 38;

                // 9. Vector Barcode
                float barcodeW = 200f;
                float barcodeH = 34f;
                DrawVectorBarcode(g, (width - barcodeW) / 2f, y, barcodeW, barcodeH, kwtCode);
                y += barcodeH + 5;
                g.DrawString($"*{kwtCode}*", footerFont, mutedBrush, new RectangleF(padX, y, contentW, 14), centerFmt);
                y += 20;

                // 10. Footer
                using (Pen dotPen = new Pen(Color.FromArgb(203, 213, 225), 1f) { DashStyle = DashStyle.Dot })
                {
                    g.DrawLine(dotPen, padX, y, width - padX, y);
                }
                y += 10;

                g.DrawString("Matur Nuwun! Terima kasih telah melestarikan budaya bahasa", footerFont, mutedBrush, new RectangleF(padX, y, contentW, 13), centerFmt);
                y += 13;
                g.DrawString("Malangan!", footerFont, mutedBrush, new RectangleF(padX, y, contentW, 13), centerFmt);
                y += 15;
                g.DrawString("Tautan unduhan dan sertifikat e-book telah dikirimkan secara", footerFont, mutedBrush, new RectangleF(padX, y, contentW, 13), centerFmt);
                y += 13;
                g.DrawString("otomatis ke kontak/WhatsApp pembeli.", footerFont, mutedBrush, new RectangleF(padX, y, contentW, 13), centerFmt);
                y += 16;
                g.DrawString("Dicetak otomatis oleh Sistem MalangVerse Kasir POS v2.4", footerFont, mutedBrush, new RectangleF(padX, y, contentW, 13), centerFmt);
            }
        }

        private static void DrawKeyValueRow(
            Graphics g, int padX, int contentW, ref float y,
            string label, string value,
            Font labelFont, Font valFont,
            Brush labelBrush, Brush valBrush,
            StringFormat leftFmt, StringFormat rightFmt)
        {
            g.DrawString(label, labelFont, labelBrush, new RectangleF(padX, y, contentW * 0.55f, 16), leftFmt);
            g.DrawString(value, valFont, valBrush, new RectangleF(padX, y, contentW, 16), rightFmt);
            y += 17;
        }

        private static string ExtractContactInfo(string rawRef)
        {
            if (string.IsNullOrWhiteSpace(rawRef)) return "-";
            int idx = rawRef.IndexOf("WA:", StringComparison.OrdinalIgnoreCase);
            if (idx >= 0)
            {
                string part = rawRef.Substring(idx + 3).Trim();
                int pipe = part.IndexOf('|');
                return pipe >= 0 ? part.Substring(0, pipe).Trim() : part;
            }
            return rawRef.Trim();
        }

        private static string BuildPaymentReference(TransaksiSummaryModel trx)
        {
            if (trx == null) return "QRIS-MV-0001";
            if (!string.IsNullOrWhiteSpace(trx.PembayaranReferensi) &&
                !trx.PembayaranReferensi.StartsWith("WA:", StringComparison.OrdinalIgnoreCase))
            {
                return trx.PembayaranReferensi;
            }
            string num = new string((trx.TransaksiId ?? "0891").Where(char.IsDigit).ToArray());
            if (string.IsNullOrEmpty(num)) num = "0891";
            return $"QRIS-MV-{num.PadLeft(8, '0')}";
        }

        private static string BuildLicenseCode(string trxId)
        {
            string digits = new string((trxId ?? "20260891").Where(char.IsDigit).ToArray());
            if (digits.Length < 4) digits = digits.PadLeft(4, '0');
            string tail = digits.Substring(digits.Length - 4);
            return $"MV-WALIKAN-{DateTime.Now:yyyy}-X{tail}";
        }

        private static void DrawVectorBarcode(Graphics g, float x, float y, float width, float height, string seedText)
        {
            int[] pattern = { 2, 1, 1, 3, 1, 2, 1, 1, 2, 2, 1, 3, 1, 1, 2, 1, 3, 1, 2, 1, 1, 2, 3, 1, 1, 2, 1, 2, 1, 3, 1, 1, 2, 1, 2, 2, 1, 1, 3, 1, 2, 1, 2 };
            int seed = Math.Abs((seedText ?? "KWT").GetHashCode());
            float totalUnits = pattern.Sum();
            float unitW = width / totalUnits;
            float cx = x;

            for (int i = 0; i < pattern.Length; i++)
            {
                int wUnits = pattern[(i + (seed % 7)) % pattern.Length];
                float barW = wUnits * unitW;
                if (i % 2 == 0)
                {
                    g.FillRectangle(Brushes.Black, cx, y, Math.Max(1f, barW - 0.3f), height);
                }
                cx += barW;
            }
        }

        private static GraphicsPath CreateRoundedRect(RectangleF bounds, float radius)
        {
            float d = radius * 2;
            GraphicsPath path = new GraphicsPath();
            path.AddArc(bounds.X, bounds.Y, d, d, 180, 90);
            path.AddArc(bounds.Right - d, bounds.Y, d, d, 270, 90);
            path.AddArc(bounds.Right - d, bounds.Bottom - d, d, d, 0, 90);
            path.AddArc(bounds.X, bounds.Bottom - d, d, d, 90, 90);
            path.CloseFigure();
            return path;
        }

        private Bitmap RenderHighResReceiptBitmap()
        {
            int baseH = CalculateBasePaperHeight();
            int scale = 2;
            Bitmap bmp = new Bitmap(BasePaperWidth * scale, baseH * scale);
            bmp.SetResolution(192, 192);
            using (Graphics g = Graphics.FromImage(bmp))
            {
                g.SmoothingMode = SmoothingMode.AntiAlias;
                g.TextRenderingHint = System.Drawing.Text.TextRenderingHint.ClearTypeGridFit;
                g.ScaleTransform(scale, scale);
                DrawReceiptSheet(g, BasePaperWidth, baseH);
            }
            return bmp;
        }

        private void SaveReceiptAsPdfOrImage()
        {
            string defaultName = "Kwitansi_" + (currentTrx?.TransaksiId ?? "MalangVerse");
            using (SaveFileDialog sfd = new SaveFileDialog
            {
                Title = "Simpan Struk Transaksi",
                FileName = defaultName,
                Filter = "PDF Document (*.pdf)|*.pdf|PNG Image (*.png)|*.png"
            })
            {
                if (sfd.ShowDialog(this) != DialogResult.OK) return;

                try
                {
                    if (sfd.FileName.EndsWith(".png", StringComparison.OrdinalIgnoreCase))
                    {
                        using (Bitmap bmp = RenderHighResReceiptBitmap())
                        {
                            bmp.Save(sfd.FileName, ImageFormat.Png);
                        }
                        MessageBox.Show("Struk berhasil disimpan sebagai gambar:\n" + sfd.FileName,
                            "Berhasil Disimpan", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    }
                    else
                    {
                        // Gunakan Microsoft Print to PDF jika tersedia untuk menghasilkan PDF asli
                        string pdfPrinter = PrinterSettings.InstalledPrinters
                            .Cast<string>()
                            .FirstOrDefault(p => p.IndexOf("PDF", StringComparison.OrdinalIgnoreCase) >= 0);

                        if (!string.IsNullOrEmpty(pdfPrinter))
                        {
                            using (PrintDocument doc = new PrintDocument())
                            {
                                doc.DocumentName = defaultName;
                                doc.PrinterSettings.PrinterName = pdfPrinter;
                                doc.PrinterSettings.PrintToFile = true;
                                doc.PrinterSettings.PrintFileName = sfd.FileName;
                                doc.PrintPage += (_, e) =>
                                {
                                    int baseH = CalculateBasePaperHeight();
                                    float left = Math.Max(20f, (e.PageBounds.Width - BasePaperWidth) / 2f);
                                    e.Graphics.TranslateTransform(left, 30f);
                                    DrawReceiptSheet(e.Graphics, BasePaperWidth, baseH);
                                };
                                doc.Print();
                            }
                            MessageBox.Show("Struk berhasil diekspor ke PDF:\n" + sfd.FileName,
                                "Simpan PDF Berhasil", MessageBoxButtons.OK, MessageBoxIcon.Information);
                        }
                        else
                        {
                            string pngFallback = Path.ChangeExtension(sfd.FileName, ".png");
                            using (Bitmap bmp = RenderHighResReceiptBitmap())
                            {
                                bmp.Save(pngFallback, ImageFormat.Png);
                            }
                            MessageBox.Show("Driver PDF tidak ditemukan di Windows, struk disimpan sebagai PNG beresolusi tinggi:\n" + pngFallback,
                                "Struk Tersimpan", MessageBoxButtons.OK, MessageBoxIcon.Information);
                        }
                    }
                }
                catch (Exception ex)
                {
                    MessageBox.Show("Gagal menyimpan struk:\n" + ex.Message,
                        "Kesalahan Simpan", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
            }
        }

        public void PrintDirect()
        {
            PrintReceipt();
        }

        private void PrintReceipt()
        {
            using (PrintDocument doc = new PrintDocument())
            {
                doc.DocumentName = "Struk_" + (currentTrx?.TransaksiId ?? "MalangVerse");
                doc.PrintPage += (_, e) =>
                {
                    int baseH = CalculateBasePaperHeight();
                    float left = Math.Max(20f, (e.PageBounds.Width - BasePaperWidth) / 2f);
                    e.Graphics.TranslateTransform(left, 30f);
                    DrawReceiptSheet(e.Graphics, BasePaperWidth, baseH);
                };
                using (PrintDialog dlg = new PrintDialog { Document = doc })
                {
                    if (dlg.ShowDialog(this) == DialogResult.OK)
                    {
                        doc.Print();
                    }
                }
            }
        }
    }
}
