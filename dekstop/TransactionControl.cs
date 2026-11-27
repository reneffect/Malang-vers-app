using System;
using System.Collections.Generic;
using System.Drawing;
using System.Linq;
using System.Windows.Forms;

namespace dekstop
{
    public partial class TransactionControl : UserControl
    {
        private sealed class EbookOption
        {
            public EbookModel Ebook { get; }
            public EbookOption(EbookModel ebook) { Ebook = ebook; }
            public override string ToString()
            {
                string akses = string.IsNullOrWhiteSpace(Ebook.EbookStatusAkses) ? "Bundle PDF + EPUB" : Ebook.EbookStatusAkses;
                return $"{Ebook.EbookJudul} ({akses})";
            }
        }

        private sealed class DiscountOption
        {
            public DiskonModel Diskon { get; }
            public string LabelText { get; }
            public DiscountOption(DiskonModel diskon, string labelText)
            {
                Diskon = diskon;
                LabelText = labelText;
            }
            public override string ToString() => LabelText;
        }

        private const string NotePlaceholder = "Tulis catatan jika ada pengembalian atau manual check...";
        private const string SearchPlaceholder = "Cari ID Pesanan (ORD-...), Nama Pelanggan, atau Judul E-Book...";
        private const string CustomerNamePlaceholder = "Ketik nama lengkap pelanggan...";
        private const string PhonePlaceholder = "Contoh: 081234567890 (maks. 14 angka)";

        private List<TransaksiSummaryModel> allTransactions = new List<TransaksiSummaryModel>();
        private readonly List<TransactionCartItem> cartItems = new List<TransactionCartItem>();
        private TransaksiSummaryModel selectedTransaction;
        private string activeDetailTransactionId;
        private int currentPage = 1;
        private const int PageSize = 10;
        private bool suppressFilter;
        private bool suppressPhoneSanitize;

        public TransactionControl()
        {
            InitializeComponent();

            ApplyPlaceholder(searchBox, SearchPlaceholder);
            ApplyPlaceholder(customerNameTextBox, CustomerNamePlaceholder);
            ApplyPlaceholder(phoneTextBox, PhonePlaceholder);

            suppressFilter = true;
            statusFilterCombo.SelectedIndex = 0;
            if (discountSelectCombo.Items.Count > 0) discountSelectCombo.SelectedIndex = 0;
            suppressFilter = false;

            orderGrid.RowTemplate.MinimumHeight = 44;
            orderGrid.AutoSizeRowsMode = DataGridViewAutoSizeRowsMode.AllCellsExceptHeaders;
            cartGrid.RowTemplate.MinimumHeight = 32;
            cartGrid.AutoSizeRowsMode = DataGridViewAutoSizeRowsMode.AllCellsExceptHeaders;
            WireEvents();
            SwitchToInputMode();

            if (!DatabaseService.IsDesignMode())
            {
                LoadFormMasterData();
                LoadTransactionsFromDb();
            }
        }

        private static void ApplyPlaceholder(TextBox box, string placeholder)
        {
            Color placeholderColor = Color.FromArgb(148, 163, 184);
            Color normalColor = Color.FromArgb(30, 41, 59);

            box.Tag = placeholder;
            box.Text = placeholder;
            box.ForeColor = placeholderColor;

            box.Enter += (_, __) =>
            {
                if (box.Text == placeholder)
                {
                    box.Text = string.Empty;
                    box.ForeColor = normalColor;
                }
            };

            box.Leave += (_, __) =>
            {
                if (string.IsNullOrWhiteSpace(box.Text))
                {
                    box.Text = placeholder;
                    box.ForeColor = placeholderColor;
                }
            };
        }

        private static string GetActualText(TextBox box)
        {
            string placeholder = box.Tag as string;
            if (!string.IsNullOrEmpty(placeholder) && box.Text == placeholder)
            {
                return string.Empty;
            }
            return (box.Text ?? string.Empty).Trim();
        }

        private static void ClearInputWithPlaceholder(TextBox box)
        {
            string placeholder = box.Tag as string;
            if (!string.IsNullOrEmpty(placeholder) && !box.Focused)
            {
                box.Text = placeholder;
                box.ForeColor = Color.FromArgb(148, 163, 184);
            }
            else
            {
                box.Text = string.Empty;
                box.ForeColor = Color.FromArgb(30, 41, 59);
            }
        }

        private void WireEvents()
        {
            firstPageBtn.Click += (_, __) => { currentPage = 1; RenderPage(); };
            prevPageBtn.Click += (_, __) => { if (currentPage > 1) { currentPage--; RenderPage(); } };
            nextPageBtn.Click += (_, __) =>
            {
                int maxPage = Math.Max(1, (int)Math.Ceiling(allTransactions.Count / (double)PageSize));
                if (currentPage < maxPage) { currentPage++; RenderPage(); }
            };
            lastPageBtn.Click += (_, __) =>
            {
                currentPage = Math.Max(1, (int)Math.Ceiling(allTransactions.Count / (double)PageSize));
                RenderPage();
            };

            phoneTextBox.KeyPress += PhoneTextBox_KeyPress;
            phoneTextBox.TextChanged += PhoneTextBox_TextChanged;

            ebookSelectCombo.SelectedIndexChanged += (_, __) => RecalculateInputTotals();
            discountSelectCombo.SelectedIndexChanged += (_, __) => RecalculateInputTotals();
            addBookBtn.Click += (_, __) => AddCurrentBookToCart();

            cartGrid.CellContentClick += CartGrid_CellContentClick;
            cartGrid.CellPainting += CartGrid_CellPainting;

        }

        private void PhoneTextBox_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (!char.IsControl(e.KeyChar) && !char.IsDigit(e.KeyChar))
            {
                e.Handled = true;
            }
        }

        private void PhoneTextBox_TextChanged(object sender, EventArgs e)
        {
            if (suppressPhoneSanitize) return;
            string current = phoneTextBox.Text ?? string.Empty;
            if (current == PhonePlaceholder) return;

            string digitsOnly = new string(current.Where(char.IsDigit).Take(14).ToArray());
            if (digitsOnly != current)
            {
                suppressPhoneSanitize = true;
                int sel = phoneTextBox.SelectionStart;
                phoneTextBox.Text = digitsOnly;
                phoneTextBox.SelectionStart = Math.Min(sel, digitsOnly.Length);
                suppressPhoneSanitize = false;
            }
        }

        private string GetSanitizedPhone()
        {
            string raw = GetActualText(phoneTextBox);
            return new string(raw.Where(char.IsDigit).Take(14).ToArray());
        }

        private void SwitchToInputMode()
        {
            activeDetailTransactionId = null;
            selectedTransaction = null;

            rightHeaderTitle.Text = "Form Input Pesanan Baru";
            selectedIdBadge.Visible = false;

            rightBodyPanel.Visible = false;
            inputBodyPanel.Visible = true;

            cancelButton.Visible = false;
            saveButton.Visible = false;
            cancelInputBtn.Visible = true;
            saveTransactionBtn.Visible = true;

            RefreshGridRowHighlights();
        }

        private void SwitchToDetailMode(TransaksiSummaryModel trx)
        {
            if (trx == null) return;

            selectedTransaction = trx;
            activeDetailTransactionId = trx.TransaksiId;

            rightHeaderTitle.Text = "Detail Pesanan & Status";
            selectedIdBadge.Text = trx.TransaksiId;
            selectedIdBadge.Visible = true;

            inputBodyPanel.Visible = false;
            rightBodyPanel.Visible = true;

            cancelInputBtn.Visible = false;
            saveTransactionBtn.Visible = false;
            cancelButton.Visible = true;
            saveButton.Visible = false;
            cancelButton.Location = new Point(Math.Max(8, rightFooterPanel.ClientSize.Width - cancelButton.Width - 16), 10);

            PopulateDetailPanel(trx);
            RefreshGridRowHighlights();
        }

        private void PopulateDetailPanel(TransaksiSummaryModel trx)
        {
            string formatText = "PDF + EPUB (Bundle)";
            if (!DatabaseService.IsDesignMode())
            {
                try
                {
                    var items = DatabaseService.GetTransactionDetails(trx.TransaksiId);
                    if (items.Count > 0)
                    {
                        var first = items[0];
                        string akses = string.IsNullOrWhiteSpace(first.EbookStatusAkses) ? "PDF + EPUB (Bundle)" : first.EbookStatusAkses;
                        formatText = items.Count > 1
                            ? $"{akses} • {items.Count} judul E-Book"
                            : akses;
                    }
                }
                catch
                {
                    // Tetap gunakan label default jika gagal mengambil detail item
                }
            }

            string methodText = string.IsNullOrWhiteSpace(trx.MetodePembayaran) || trx.MetodePembayaran == "-"
                ? "QRIS"
                : trx.MetodePembayaran;

            detailPesananStatusControl.SetOrderDetail(
                trx.JudulRingkas,
                formatText,
                methodText,
                DatabaseService.FormatRupiah(trx.TransaksiGrandtotal));
        }

        private void LoadFormMasterData()
        {
            try
            {
                var ebooks = DatabaseService.GetEbooks().Where(e => e.EbookAktif).ToList();
                ebookSelectCombo.Items.Clear();
                foreach (var eb in ebooks)
                {
                    ebookSelectCombo.Items.Add(new EbookOption(eb));
                }

                if (ebookSelectCombo.Items.Count > 0)
                {
                    ebookSelectCombo.SelectedIndex = 0;
                }

                var diskons = DatabaseService.GetDiskons()
                    .Where(d => d.DiskonAktif && (!d.DiskonMulaiBerlaku.HasValue || d.DiskonMulaiBerlaku.Value <= DateTime.Now) && (!d.DiskonMasaBerlaku.HasValue || d.DiskonMasaBerlaku.Value >= DateTime.Now))
                    .ToList();

                discountSelectCombo.Items.Clear();
                discountSelectCombo.Items.Add(new DiscountOption(null, "Rp 0 (Tanpa Diskon)"));
                foreach (var d in diskons)
                {
                    bool isPercent = d.DiskonJenis.IndexOf("Persen", StringComparison.OrdinalIgnoreCase) >= 0;
                    string desc = isPercent
                        ? $"{d.DiskonId} - Diskon {d.DiskonNilai:0}%"
                        : $"{d.DiskonId} - Potongan {DatabaseService.FormatRupiah(d.DiskonNilai)}";
                    discountSelectCombo.Items.Add(new DiscountOption(d, desc));
                }
                discountSelectCombo.SelectedIndex = 0;

                RecalculateInputTotals();
            }
            catch (Exception ex)
            {
                MessageBox.Show("Gagal memuat data master form transaksi:\n" + ex.Message,
                    "Database Error", MessageBoxButtons.OK, MessageBoxIcon.Warning);
            }
        }

        private void AddCurrentBookToCart()
        {
            if (!(ebookSelectCombo.SelectedItem is EbookOption ebOpt))
            {
                MessageBox.Show("Silakan pilih produk E-Book terlebih dahulu.",
                    "Validasi", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }

            bool alreadyAdded = cartItems.Any(x =>
                string.Equals(x.EbookId, ebOpt.Ebook.EbookId, StringComparison.OrdinalIgnoreCase));
            if (alreadyAdded)
            {
                MessageBox.Show("E-Book tersebut sudah ada di daftar transaksi.",
                    "Informasi", MessageBoxButtons.OK, MessageBoxIcon.Information);
                return;
            }

            cartItems.Add(new TransactionCartItem
            {
                EbookId = ebOpt.Ebook.EbookId,
                EbookJudul = ebOpt.Ebook.EbookJudul,
                EbookStatusAkses = ebOpt.Ebook.EbookStatusAkses,
                UnitPrice = ebOpt.Ebook.EbookHarga
            });

            RenderCartGrid();
        }

        private void RenderCartGrid()
        {
            cartGrid.Rows.Clear();
            foreach (var item in cartItems)
            {
                int rowIdx = cartGrid.Rows.Add(
                    item.EbookJudul,
                    DatabaseService.FormatRupiah(item.Subtotal),
                    "✕");
                cartGrid.Rows[rowIdx].Tag = item;
            }

            cartCaption.Text = $"Daftar Buku Dipilih ({cartItems.Count} judul):";
            AdjustCartGridLayout();
            RecalculateInputTotals();
        }

        private void AdjustCartGridLayout()
        {
            int rowsHeight = 0;
            foreach (DataGridViewRow row in cartGrid.Rows)
            {
                rowsHeight += row.Height;
            }

            int minGridHeight = 64;
            int targetGridHeight = Math.Max(minGridHeight, cartGrid.ColumnHeadersHeight + rowsHeight + 4);

            cartGrid.Height = targetGridHeight;
            discountSelectCaption.Top = cartGrid.Bottom + 8;
            discountSelectCombo.Top = discountSelectCaption.Bottom + 3;
            finalSubtotalCaption.Top = discountSelectCombo.Bottom + 8;
            finalSubtotalBox.Top = finalSubtotalCaption.Bottom + 3;
            ebookInputGroupBox.Height = finalSubtotalBox.Bottom + 12;

            paymentInputGroupBox.Top = ebookInputGroupBox.Bottom + 10;
            inputBottomSpacer.Top = paymentInputGroupBox.Bottom + 8;
        }

        private void CartGrid_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {
            if (e.RowIndex < 0 || e.ColumnIndex != colCartDel.Index) return;
            if (cartGrid.Rows[e.RowIndex].Tag is TransactionCartItem item)
            {
                cartItems.Remove(item);
                RenderCartGrid();
            }
        }

        private void CartGrid_CellPainting(object sender, DataGridViewCellPaintingEventArgs e)
        {
            if (e.RowIndex < 0 || e.ColumnIndex != colCartDel.Index) return;
            e.PaintBackground(e.ClipBounds, true);

            int btnH = Math.Min(20, Math.Max(16, e.CellBounds.Height - 6));
            Rectangle rect = new Rectangle(e.CellBounds.X + 4, e.CellBounds.Y + (e.CellBounds.Height - btnH) / 2,
                Math.Max(18, e.CellBounds.Width - 8), btnH);
            using (SolidBrush bg = new SolidBrush(Color.FromArgb(254, 226, 226)))
            using (Pen border = new Pen(Color.FromArgb(252, 165, 165)))
            {
                e.Graphics.FillRectangle(bg, rect);
                e.Graphics.DrawRectangle(border, rect);
            }

            TextRenderer.DrawText(e.Graphics, "✕", new Font("Segoe UI", 7.5F, FontStyle.Bold),
                rect, Color.FromArgb(220, 38, 38),
                TextFormatFlags.HorizontalCenter | TextFormatFlags.VerticalCenter);
            e.Handled = true;
        }

        private decimal CalculateDiscountNominal(DiskonModel diskon, decimal subtotal)
        {
            if (diskon == null || subtotal <= 0) return 0m;
            if (diskon.DiskonMinimalTransaksi.HasValue && subtotal < diskon.DiskonMinimalTransaksi.Value)
            {
                return 0m;
            }

            decimal potongan;
            if (diskon.DiskonJenis.IndexOf("Persen", StringComparison.OrdinalIgnoreCase) >= 0)
            {
                potongan = Math.Round(subtotal * (diskon.DiskonNilai / 100m), 0, MidpointRounding.AwayFromZero);
            }
            else
            {
                potongan = diskon.DiskonNilai;
            }

            if (potongan < 0m) potongan = 0m;
            if (potongan > subtotal) potongan = subtotal;
            return potongan;
        }

        private void RecalculateInputTotals()
        {
            decimal unitPrice = 0m;
            if (ebookSelectCombo.SelectedItem is EbookOption ebOpt)
            {
                unitPrice = ebOpt.Ebook.EbookHarga;
            }

            decimal rawSubtotal = cartItems.Count > 0
                ? cartItems.Sum(i => i.Subtotal)
                : unitPrice;

            DiskonModel selectedDiskon = (discountSelectCombo.SelectedItem as DiscountOption)?.Diskon;
            decimal discountAmount = CalculateDiscountNominal(selectedDiskon, rawSubtotal);
            decimal finalTotal = Math.Max(0m, rawSubtotal - discountAmount);

            unitPriceBox.Text = DatabaseService.FormatRupiah(unitPrice);
            finalSubtotalValue.Text = DatabaseService.FormatRupiah(finalTotal);
        }

        private void ResetInputForm()
        {
            ClearInputWithPlaceholder(customerNameTextBox);
            ClearInputWithPlaceholder(phoneTextBox);

            cartItems.Clear();
            RenderCartGrid();

            if (ebookSelectCombo.Items.Count > 0)
            {
                ebookSelectCombo.SelectedIndex = 0;
            }

            if (discountSelectCombo.Items.Count > 0)
            {
                discountSelectCombo.SelectedIndex = 0;
            }

            RecalculateInputTotals();
        }

        private void LoadTransactionsFromDb()
        {
            try
            {
                string kw = GetActualText(searchBox);
                string st = statusFilterCombo.SelectedItem?.ToString() ?? "Semua Status";
                allTransactions = DatabaseService.GetTransactions(kw, st);
                currentPage = 1;
                RenderPage();
            }
            catch (Exception ex)
            {
                MessageBox.Show("Gagal memuat data transaksi dari database:\n" + ex.Message,
                    "Database Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void RenderPage()
        {
            orderGrid.Rows.Clear();
            int totalRecords = allTransactions.Count;
            int totalPages = Math.Max(1, (int)Math.Ceiling(totalRecords / (double)PageSize));
            if (currentPage > totalPages) currentPage = totalPages;

            var pageItems = allTransactions
                .Skip((currentPage - 1) * PageSize)
                .Take(PageSize)
                .ToList();

            int rowNumber = (currentPage - 1) * PageSize + 1;
            decimal pageTotalSum = 0;

            foreach (var trx in pageItems)
            {
                pageTotalSum += trx.TransaksiGrandtotal;
                string dateStr = trx.TransaksiTanggal.ToString("dd MMM yyyy\nHH:mm");
                string priceStr = DatabaseService.FormatRupiah(trx.TransaksiGrandtotal);
                AddOrderRow(rowNumber.ToString(), trx, dateStr, priceStr);
                rowNumber++;
            }

            countInfoLabel.Text = $"Menampilkan {pageItems.Count} dari {totalRecords} transaksi";
            countInfoLabel.Left = Math.Max(200, leftCardHeader.ClientSize.Width - countInfoLabel.Width - 14);
            pageInfoLabel.Text = $"Halaman {currentPage} dari {totalPages}";
            int nextX = Math.Max(205, pageInfoLabel.Right + 10);
            nextPageBtn.Location = new Point(nextX, nextPageBtn.Location.Y);
            lastPageBtn.Location = new Point(nextX + nextPageBtn.Width + 4, lastPageBtn.Location.Y);
            totalPageValueLabel.Text = "Total Pendapatan: " + DatabaseService.FormatRupiah(pageTotalSum);

            RefreshGridRowHighlights();
        }

        private void AddOrderRow(string no, TransaksiSummaryModel trx, string date, string price)
        {
            string titleInfo = string.IsNullOrWhiteSpace(trx.UserNama)
                ? trx.JudulRingkas
                : $"{trx.JudulRingkas} ({trx.UserNama})";

            int idx = orderGrid.Rows.Add(no, trx.TransaksiId, titleInfo, date, price, trx.TransaksiStatus, "👁 Lihat Detail");
            DataGridViewRow row = orderGrid.Rows[idx];
            row.Tag = trx;
            row.Cells[0].Style.Alignment = DataGridViewContentAlignment.MiddleCenter;
            row.Cells[1].Style.Font = new Font("Georgia", 8.25F, FontStyle.Bold);

            DataGridViewCell statusCell = row.Cells[5];
            if (trx.TransaksiStatus.Equals("Pending", StringComparison.OrdinalIgnoreCase))
            {
                statusCell.Style.BackColor = Color.FromArgb(254, 249, 195);
                statusCell.Style.ForeColor = Color.FromArgb(161, 98, 7);
            }
            else if (trx.TransaksiStatus.Equals("Success", StringComparison.OrdinalIgnoreCase))
            {
                statusCell.Style.BackColor = Color.FromArgb(220, 252, 231);
                statusCell.Style.ForeColor = Color.FromArgb(21, 128, 61);
            }
            else
            {
                statusCell.Style.BackColor = Color.FromArgb(254, 226, 226);
                statusCell.Style.ForeColor = Color.FromArgb(185, 28, 28);
            }
        }

        private void RefreshGridRowHighlights()
        {
            orderGrid.ClearSelection();
            Color normalText = Color.FromArgb(30, 41, 59);
            Color mutedNo = Color.FromArgb(100, 116, 139);
            Color activeBlue = Color.FromArgb(37, 99, 235);

            foreach (DataGridViewRow row in orderGrid.Rows)
            {
                bool isActive = !string.IsNullOrEmpty(activeDetailTransactionId)
                    && row.Tag is TransaksiSummaryModel trx
                    && string.Equals(trx.TransaksiId, activeDetailTransactionId, StringComparison.OrdinalIgnoreCase);

                row.Cells[0].Style.ForeColor = isActive ? activeBlue : mutedNo;
                row.Cells[0].Style.Font = new Font("Georgia", 8.25F, isActive ? FontStyle.Bold : FontStyle.Regular);
                row.Cells[1].Style.ForeColor = isActive ? activeBlue : normalText;

                if (isActive)
                {
                    row.Selected = true;
                }
            }

            orderGrid.Invalidate();
        }

        private void OrderGrid_CellPainting(object sender, DataGridViewCellPaintingEventArgs e)
        {
            if (e.RowIndex >= 0 && e.ColumnIndex == 6)
            {
                e.PaintBackground(e.ClipBounds, true);

                bool isActive = false;
                if (orderGrid.Rows[e.RowIndex].Tag is TransaksiSummaryModel trx && !string.IsNullOrEmpty(activeDetailTransactionId))
                {
                    isActive = string.Equals(trx.TransaksiId, activeDetailTransactionId, StringComparison.OrdinalIgnoreCase);
                }

                int btnHeight = Math.Min(28, Math.Max(22, e.CellBounds.Height - 10));
                Rectangle btnRect = new Rectangle(
                    e.CellBounds.X + 4,
                    e.CellBounds.Y + (e.CellBounds.Height - btnHeight) / 2,
                    Math.Max(40, e.CellBounds.Width - 8),
                    btnHeight);

                Color fill = isActive ? Color.FromArgb(37, 99, 235) : Color.White;
                Color border = isActive ? Color.FromArgb(29, 78, 216) : Color.FromArgb(203, 213, 225);
                Color textCol = isActive ? Color.White : Color.FromArgb(30, 41, 59);

                using (SolidBrush bgBrush = new SolidBrush(fill))
                using (Pen borderPen = new Pen(border, 1))
                {
                    e.Graphics.FillRectangle(bgBrush, btnRect);
                    e.Graphics.DrawRectangle(borderPen, btnRect);
                }

                TextRenderer.DrawText(
                    e.Graphics,
                    "👁 Lihat Detail",
                    new Font("Georgia", 7.75F, isActive ? FontStyle.Bold : FontStyle.Regular),
                    btnRect,
                    textCol,
                    TextFormatFlags.HorizontalCenter | TextFormatFlags.VerticalCenter | TextFormatFlags.EndEllipsis
                );

                e.Handled = true;
            }
        }

        private void OrderGrid_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {
            if (e.RowIndex >= 0 && e.ColumnIndex == 6)
            {
                if (orderGrid.Rows[e.RowIndex].Tag is TransaksiSummaryModel trx)
                {
                    SwitchToDetailMode(trx);
                }
            }
        }

        private void FilterChanged(object sender, EventArgs e)
        {
            if (suppressFilter || DatabaseService.IsDesignMode()) return;
            LoadTransactionsFromDb();
        }

        private void SaveTransactionBtn_Click(object sender, EventArgs e)
        {
            string customerName = GetActualText(customerNameTextBox);
            if (string.IsNullOrWhiteSpace(customerName))
            {
                MessageBox.Show("Nama pelanggan wajib diisi secara manual.",
                    "Validasi Transaksi", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                customerNameTextBox.Focus();
                return;
            }

            string rawPhone = GetActualText(phoneTextBox);
            string cleanPhone = GetSanitizedPhone();
            if (!string.IsNullOrWhiteSpace(rawPhone) && (rawPhone != cleanPhone || cleanPhone.Length > 14))
            {
                MessageBox.Show("Nomor WhatsApp hanya boleh berisi angka dengan maksimal 14 digit.",
                    "Validasi No. WhatsApp", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                phoneTextBox.Focus();
                return;
            }

            List<TransactionCartItem> itemsToSave = new List<TransactionCartItem>(cartItems);
            if (itemsToSave.Count == 0)
            {
                if (!(ebookSelectCombo.SelectedItem is EbookOption ebOpt))
                {
                    MessageBox.Show("Silakan pilih produk E-Book terlebih dahulu.",
                        "Validasi Transaksi", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                    ebookSelectCombo.Focus();
                    return;
                }

                itemsToSave.Add(new TransactionCartItem
                {
                    EbookId = ebOpt.Ebook.EbookId,
                    EbookJudul = ebOpt.Ebook.EbookJudul,
                    EbookStatusAkses = ebOpt.Ebook.EbookStatusAkses,
                    UnitPrice = ebOpt.Ebook.EbookHarga
                });
            }

            decimal subtotal = itemsToSave.Sum(i => i.Subtotal);
            DiskonModel selectedDiskon = (discountSelectCombo.SelectedItem as DiscountOption)?.Diskon;
            if (selectedDiskon != null && selectedDiskon.DiskonMinimalTransaksi.HasValue && subtotal < selectedDiskon.DiskonMinimalTransaksi.Value)
            {
                MessageBox.Show(
                    $"Diskon {selectedDiskon.DiskonId} memerlukan minimal transaksi sebesar {DatabaseService.FormatRupiah(selectedDiskon.DiskonMinimalTransaksi.Value)}.",
                    "Minimal Transaksi Diskon", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                return;
            }

            decimal discountNominal = CalculateDiscountNominal(selectedDiskon, subtotal);

            try
            {
                saveTransactionBtn.Enabled = false;
                string newTrxId = DatabaseService.CreateTransaction(
                    customerName,
                    cleanPhone,
                    itemsToSave,
                    selectedDiskon?.DiskonId,
                    discountNominal,
                    "QRIS"
                );

                MessageBox.Show(
                    $"Transaksi baru {newTrxId} untuk {customerName} ({itemsToSave.Count} judul buku) berhasil disimpan!",
                    "MalangVerse Kasir", MessageBoxButtons.OK, MessageBoxIcon.Information);

                ResetInputForm();
                LoadTransactionsFromDb();
            }
            catch (Exception ex)
            {
                MessageBox.Show("Gagal menyimpan transaksi baru:\n" + ex.Message,
                    "Kesalahan Database", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
            finally
            {
                saveTransactionBtn.Enabled = true;
            }
        }

        private void CancelInputBtn_Click(object sender, EventArgs e)
        {
            ResetInputForm();
        }

        private void CancelButton_Click(object sender, EventArgs e)
        {
            SwitchToInputMode();
        }

        private void bodyLayout_Paint(object sender, PaintEventArgs e)
        {

        }
    }
}
