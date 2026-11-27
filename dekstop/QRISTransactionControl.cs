using System;
using System.Collections.Generic;
using System.Data;
using System.Drawing;
using System.Globalization;
using System.Linq;
using System.Windows.Forms;

namespace dekstop
{
    public partial class QRISTransactionControl : UserControl
    {
        private DataTable dtQris;
        private List<PembayaranModel> allPayments = new List<PembayaranModel>();
        private PembayaranModel selectedPayment;
        private int currentPage = 1;
        private const int PageSize = 8;
        private const string SearchPlaceholder = "Cari ID Referensi / Nama / Produk...";
        private static readonly CultureInfo IdCulture = new CultureInfo("id-ID");

        public QRISTransactionControl()
        {
            InitializeComponent();

            // Halaman QRIS pada aplikasi Admin bersifat read-only:
            // hanya untuk memantau transaksi, bukan memverifikasi atau mencetak struk.
            btnVerifikasi.Visible = false;
            btnVerifikasi.Enabled = false;
            btnCetakStruk.Visible = false;
            btnCetakStruk.Enabled = false;

            SetupDataGridView();

            if (!DatabaseService.IsDesignMode())
            {
                LoadQrisTransactions();
            }
        }

        private void SetupDataGridView()
        {
            dtQris = new DataTable();
            dtQris.Columns.Add("Pilih", typeof(bool));
            dtQris.Columns.Add("ID REFERENSI", typeof(string));
            dtQris.Columns.Add("NAMA PENGGUNA", typeof(string));
            dtQris.Columns.Add("ITEM / PRODUK", typeof(string));
            dtQris.Columns.Add("NOMINAL (RP)", typeof(string));
            dtQris.Columns.Add("TANGGAL & WAKTU", typeof(string));
            dtQris.Columns.Add("STATUS", typeof(string));
            dtQris.Columns.Add("AKSI", typeof(string));
            dtQris.Columns.Add("ModelRef", typeof(PembayaranModel));

            dgvQris.DataSource = dtQris;
            dgvQris.Columns["ModelRef"].Visible = false;

            dgvQris.Columns["Pilih"].HeaderText = "";
            dgvQris.Columns["Pilih"].FillWeight = 24;
            dgvQris.Columns["ID REFERENSI"].FillWeight = 78;
            dgvQris.Columns["NAMA PENGGUNA"].FillWeight = 86;
            dgvQris.Columns["ITEM / PRODUK"].FillWeight = 112;
            dgvQris.Columns["NOMINAL (RP)"].FillWeight = 66;
            dgvQris.Columns["TANGGAL & WAKTU"].FillWeight = 86;
            dgvQris.Columns["STATUS"].FillWeight = 60;
            dgvQris.Columns["AKSI"].FillWeight = 74;

            dgvQris.Columns["NOMINAL (RP)"].DefaultCellStyle.Alignment = DataGridViewContentAlignment.MiddleRight;
            dgvQris.Columns["STATUS"].DefaultCellStyle.Alignment = DataGridViewContentAlignment.MiddleCenter;
            dgvQris.Columns["AKSI"].DefaultCellStyle.Alignment = DataGridViewContentAlignment.MiddleCenter;
        }

        public void LoadQrisTransactions(string keyword = "")
        {
            try
            {
                allPayments = DatabaseService.GetPayments(keyword, "QRIS");

                int total = allPayments.Count;
                var verifiedList = allPayments
                    .Where(x => x.PembayaranStatus.Equals("Verified", StringComparison.OrdinalIgnoreCase) ||
                                x.PembayaranStatus.Equals("Success", StringComparison.OrdinalIgnoreCase))
                    .ToList();
                int failedOrPending = total - verifiedList.Count;
                decimal totalVolume = verifiedList.Sum(x => x.PembayaranJumlah);
                double successRate = total > 0 ? (verifiedList.Count * 100.0 / total) : 0.0;

                lblCardTotalVal.Text = total.ToString("N0", IdCulture);
                lblCardVolumeVal.Text = totalVolume.ToString("N0", IdCulture);
                lblCardSuccessVal.Text = verifiedList.Count.ToString("N0", IdCulture);
                lblCardSuccessPct.Text = $"({successRate:0.0}%)";
                lblCardFailedVal.Text = failedOrPending.ToString("N0", IdCulture);

                currentPage = 1;
                RenderCurrentPage();

                if (FindForm() is MainForm mf)
                {
                    mf.UpdateQrisBadgeCount();
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Gagal memuat riwayat transaksi QRIS:" + ex.Message,
                    "Kesalahan Database", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private string MapDisplayStatus(string dbStatus)
        {
            if (string.IsNullOrWhiteSpace(dbStatus)) return "Tertunda";
            if (dbStatus.Equals("Verified", StringComparison.OrdinalIgnoreCase) ||
                dbStatus.Equals("Success", StringComparison.OrdinalIgnoreCase))
                return "Berhasil";
            if (dbStatus.Equals("Pending", StringComparison.OrdinalIgnoreCase))
                return "Tertunda";
            return "Gagal";
        }

        private void RenderCurrentPage()
        {
            dtQris.Rows.Clear();
            int totalRecords = allPayments.Count;
            int totalPages = Math.Max(1, (int)Math.Ceiling(totalRecords / (double)PageSize));
            if (currentPage < 1) currentPage = 1;
            if (currentPage > totalPages) currentPage = totalPages;

            int skip = (currentPage - 1) * PageSize;
            var pageItems = allPayments.Skip(skip).Take(PageSize).ToList();

            for (int i = 0; i < pageItems.Count; i++)
            {
                PembayaranModel p = pageItems[i];
                DateTime displayDate = p.PembayaranTanggal ?? p.TransaksiTanggal;
                string statusText = MapDisplayStatus(p.PembayaranStatus);

                dtQris.Rows.Add(
                    i == 0,
                    p.TransaksiId,
                    p.UserNama,
                    p.JudulRingkas,
                    DatabaseService.FormatRupiah(p.PembayaranJumlah),
                    displayDate.ToString("dd MMM yyyy HH:mm:ss", IdCulture),
                    statusText,
                    "Lihat Detail",
                    p
                );
            }

            if (pageItems.Count > 0)
            {
                dgvQris.ClearSelection();
                dgvQris.Rows[0].Selected = true;
                BindDetailDialog(pageItems[0]);
                lblSelectedInfo.Text = $"Baris Terpilih: 1 dari {totalRecords}";
                lblPaginationInfo.Text = $"Menampilkan {skip + 1} - {skip + pageItems.Count} dari {totalRecords} transaksi";
            }
            else
            {
                ClearDetailDialog();
                lblSelectedInfo.Text = "Baris Terpilih: 0 dari 0";
                lblPaginationInfo.Text = "Menampilkan 0 transaksi";
            }

            BuildPaginationButtons(totalPages);
            dgvQris.Refresh();
        }

        private void BuildPaginationButtons(int totalPages)
        {
            flpPaginationButtons.Controls.Clear();

            AddPageButton("<<", currentPage > 1, () => { currentPage = 1; RenderCurrentPage(); }, false);
            AddPageButton("<", currentPage > 1, () => { currentPage--; RenderCurrentPage(); }, false);

            int startPage = Math.Max(1, currentPage - 1);
            int endPage = Math.Min(totalPages, startPage + 2);
            if (endPage - startPage < 2)
                startPage = Math.Max(1, endPage - 2);

            for (int p = startPage; p <= endPage; p++)
            {
                int targetPage = p;
                AddPageButton(p.ToString(), true, () => { currentPage = targetPage; RenderCurrentPage(); }, p == currentPage);
            }

            AddPageButton(">", currentPage < totalPages, () => { currentPage++; RenderCurrentPage(); }, false);
            AddPageButton(">>", currentPage < totalPages, () => { currentPage = totalPages; RenderCurrentPage(); }, false);
        }

        private void AddPageButton(string text, bool enabled, Action onClick, bool isActive)
        {
            Button btn = new Button
            {
                Text = text,
                Width = text.Length > 1 ? 28 : 24,
                Height = 23,
                Enabled = enabled,
                Cursor = enabled ? Cursors.Hand : Cursors.Default,
                FlatStyle = FlatStyle.Flat,
                Font = new Font("Segoe UI", 7.8F, isActive ? FontStyle.Bold : FontStyle.Regular),
                BackColor = isActive ? Color.FromArgb(37, 99, 235) : Color.White,
                ForeColor = isActive ? Color.White : Color.FromArgb(51, 65, 85),
                Margin = new Padding(2, 0, 2, 0)
            };
            btn.FlatAppearance.BorderColor = isActive ? Color.FromArgb(37, 99, 235) : Color.FromArgb(203, 213, 225);
            btn.Click += (_, __) => onClick();
            flpPaginationButtons.Controls.Add(btn);
        }

        private void dgvQris_CellFormatting(object sender, DataGridViewCellFormattingEventArgs e)
        {
            if (e.RowIndex < 0 || e.RowIndex >= dtQris.Rows.Count) return;

            bool isSelectedRow = dtQris.Rows[e.RowIndex]["Pilih"] != DBNull.Value &&
                                 Convert.ToBoolean(dtQris.Rows[e.RowIndex]["Pilih"]);
            string colName = dgvQris.Columns[e.ColumnIndex].Name;

            if (isSelectedRow)
                e.CellStyle.BackColor = Color.FromArgb(239, 246, 255);

            if (colName == "ID REFERENSI")
            {
                e.CellStyle.Font = new Font("Segoe UI", 8.5F, FontStyle.Bold);
                e.CellStyle.ForeColor = isSelectedRow ? Color.FromArgb(37, 99, 235) : Color.FromArgb(51, 65, 85);
            }
            else if (colName == "NAMA PENGGUNA")
            {
                e.CellStyle.Font = new Font("Segoe UI", 8.5F, FontStyle.Bold);
                e.CellStyle.ForeColor = Color.FromArgb(15, 23, 42);
            }
            else if (colName == "NOMINAL (RP)")
            {
                e.CellStyle.Font = new Font("Segoe UI", 8.5F, FontStyle.Bold);
                e.CellStyle.ForeColor = Color.FromArgb(15, 23, 42);
            }
            else if (colName == "STATUS")
            {
                string st = e.Value?.ToString() ?? "";
                e.CellStyle.Font = new Font("Segoe UI", 7.8F, FontStyle.Bold);
                if (st == "Berhasil")
                {
                    e.CellStyle.BackColor = Color.FromArgb(220, 252, 231);
                    e.CellStyle.ForeColor = Color.FromArgb(21, 128, 61);
                }
                else if (st == "Tertunda")
                {
                    e.CellStyle.BackColor = Color.FromArgb(254, 249, 195);
                    e.CellStyle.ForeColor = Color.FromArgb(180, 83, 9);
                }
                else
                {
                    e.CellStyle.BackColor = Color.FromArgb(254, 226, 226);
                    e.CellStyle.ForeColor = Color.FromArgb(185, 28, 28);
                }
            }
            else if (colName == "AKSI")
            {
                e.CellStyle.Font = new Font("Segoe UI", 8F, FontStyle.Bold);
                e.CellStyle.ForeColor = Color.FromArgb(37, 99, 235);
            }
        }

        private void dgvQris_CellClick(object sender, DataGridViewCellEventArgs e)
        {
            if (e.RowIndex < 0 || e.RowIndex >= dtQris.Rows.Count) return;

            for (int i = 0; i < dtQris.Rows.Count; i++)
                dtQris.Rows[i]["Pilih"] = (i == e.RowIndex);

            if (dtQris.Rows[e.RowIndex]["ModelRef"] is PembayaranModel p)
            {
                BindDetailDialog(p);
                int globalIndex = ((currentPage - 1) * PageSize) + e.RowIndex + 1;
                lblSelectedInfo.Text = $"Baris Terpilih: {globalIndex} dari {allPayments.Count}";
            }

            dgvQris.Refresh();

            // Klik baris/kolom aksi hanya memilih transaksi untuk ditinjau.
            // Tidak ada akses cetak struk pada halaman monitoring Admin.
        }

        private void BindDetailDialog(PembayaranModel p)
        {
            selectedPayment = p;
            lblDialogTitle.Text = $"Dialog: [Detail Transaksi & Struk QRIS - {p.TransaksiId}]";

            string statusDisplay = MapDisplayStatus(p.PembayaranStatus);
            if (statusDisplay == "Berhasil")
            {
                pnlStatusBanner.BackColor = Color.FromArgb(240, 253, 244);
                lblBannerIcon.ForeColor = Color.FromArgb(22, 163, 74);
                lblBannerIcon.Text = "✔";
                lblBannerTitle.ForeColor = Color.FromArgb(21, 128, 61);
                lblBannerTitle.Text = "TRANSAKSI BERHASIL (LUNAS)";
                lblBannerSubtitle.ForeColor = Color.FromArgb(22, 163, 74);
                lblBannerSubtitle.Text = "Telah diverifikasi oleh Gateway Bank Indonesia / ASPI";

                lblSettlementVal.ForeColor = Color.FromArgb(21, 128, 61);
                lblSettlementVal.Text = "Sudah Masuk Rekening Penampung (Batch #441)";
            }
            else if (statusDisplay == "Tertunda")
            {
                pnlStatusBanner.BackColor = Color.FromArgb(255, 251, 235);
                lblBannerIcon.ForeColor = Color.FromArgb(217, 119, 6);
                lblBannerIcon.Text = "⏳";
                lblBannerTitle.ForeColor = Color.FromArgb(180, 83, 9);
                lblBannerTitle.Text = "MENUNGGU KONFIRMASI / TERTUNDA";
                lblBannerSubtitle.ForeColor = Color.FromArgb(217, 119, 6);
                lblBannerSubtitle.Text = "Menunggu verifikasi pembayaran QRIS oleh Kasir";

                lblSettlementVal.ForeColor = Color.FromArgb(180, 83, 9);
                lblSettlementVal.Text = "Menunggu Verifikasi & Settlement QRIS";
            }
            else
            {
                pnlStatusBanner.BackColor = Color.FromArgb(254, 242, 242);
                lblBannerIcon.ForeColor = Color.FromArgb(220, 38, 38);
                lblBannerIcon.Text = "✖";
                lblBannerTitle.ForeColor = Color.FromArgb(185, 28, 28);
                lblBannerTitle.Text = "TRANSAKSI GAGAL / DITOLAK";
                lblBannerSubtitle.ForeColor = Color.FromArgb(220, 38, 38);
                lblBannerSubtitle.Text = "Pembayaran dibatalkan atau gagal diverifikasi";

                lblSettlementVal.ForeColor = Color.FromArgb(185, 28, 28);
                lblSettlementVal.Text = "Tidak Diproses (Transaksi Ditolak)";
            }

            string digitsInPayId = new string((p.PembayaranId ?? "").Where(char.IsDigit).ToArray());
            string rrnNumeric = string.IsNullOrWhiteSpace(digitsInPayId)
                ? "902837461920"
                : ("902837" + digitsInPayId.PadLeft(6, '0'));

            lblMerchantNameVal.Text = "MalangVerse Digital PT";
            lblNmidVal.Text = "ID1020039485721";
            lblAcquirerVal.Text = "Bank Indonesia / Netzme / ASPI";
            lblTerminalVal.Text = "MLG-QRIS-001";
            lblRrnVal.Text = rrnNumeric;
            lblNoRefVal.Text = string.IsNullOrWhiteSpace(p.PembayaranReferensi) ? p.TransaksiId : p.PembayaranReferensi;

            DateTime trxTime = p.PembayaranTanggal ?? p.TransaksiTanggal;
            lblWaktuTrxVal.Text = trxTime.ToString("dd MMMM yyyy, HH:mm:ss 'WIB'", IdCulture);

            lblCustNameVal.Text = p.UserNama;
            string emailUser = !string.IsNullOrWhiteSpace(p.UserUsername)
                ? p.UserUsername.ToLowerInvariant().Replace(" ", ".")
                : (p.UserNama ?? "pelanggan").ToLowerInvariant().Replace(" ", ".");
            lblCustEmailVal.Text = $"{emailUser}@arema.id";

            lblProductNameVal.Text = p.JudulRingkas;
            lblProductSubVal.Text = $"Akses Kamus ({p.EbookStatusAkses})";

            lblBillAmountVal.Text = DatabaseService.FormatRupiah(p.TransaksiGrandtotal);
            lblPaidAmountVal.Text = DatabaseService.FormatRupiah(p.PembayaranJumlah);

            // Admin hanya memantau. Tombol verifikasi tidak pernah ditampilkan
            // meskipun status pembayaran masih Pending.
            btnVerifikasi.Visible = false;
            btnVerifikasi.Enabled = false;
            btnCetakStruk.Visible = false;
            btnCetakStruk.Enabled = false;
        }

        private void ClearDetailDialog()
        {
            selectedPayment = null;
            lblDialogTitle.Text = "Dialog: [Detail Transaksi & Struk QRIS - Belum Dipilih]";
            lblRrnVal.Text = "-";
            lblNoRefVal.Text = "-";
            lblWaktuTrxVal.Text = "-";
            lblCustNameVal.Text = "-";
            lblCustEmailVal.Text = "-";
            lblProductNameVal.Text = "-";
            lblProductSubVal.Text = "-";
            lblBillAmountVal.Text = "Rp 0";
            lblPaidAmountVal.Text = "Rp 0";
            lblSettlementVal.Text = "-";
            btnVerifikasi.Visible = false;
            btnVerifikasi.Enabled = false;
            btnCetakStruk.Visible = false;
            btnCetakStruk.Enabled = false;
        }

        // Halaman QRIS Admin bersifat read-only. Tidak ada alur cetak struk
        // maupun verifikasi dari kontrol ini.
        private void OpenOfficialReceipt()
        {
            MessageBox.Show("Halaman QRIS Admin hanya untuk pemantauan. Pencetakan struk tidak tersedia.",
                "Akses Tidak Tersedia", MessageBoxButtons.OK, MessageBoxIcon.Information);
        }

        private void btnCetakStruk_Click(object sender, EventArgs e)
        {
            // Sengaja tidak menjalankan pencetakan untuk role Admin.
        }

        private void btnVerifikasi_Click(object sender, EventArgs e)
        {
            // Sengaja tidak menjalankan verifikasi untuk role Admin.
        }

        private void btnTutup_Click(object sender, EventArgs e)
        {
            for (int i = 0; i < dtQris.Rows.Count; i++)
                dtQris.Rows[i]["Pilih"] = false;

            dgvQris.ClearSelection();
            lblSelectedInfo.Text = $"Baris Terpilih: 0 dari {allPayments.Count}";
            ClearDetailDialog();
            dgvQris.Refresh();
        }

        private void btnSearch_Click(object sender, EventArgs e)
        {
            string kw = txtSearch.Text.Trim();
            if (kw == SearchPlaceholder) kw = "";
            LoadQrisTransactions(kw);
        }

        private void txtSearch_Enter(object sender, EventArgs e)
        {
            if (txtSearch.Text == SearchPlaceholder)
            {
                txtSearch.Text = "";
                txtSearch.ForeColor = Color.FromArgb(15, 23, 42);
            }
        }

        private void txtSearch_Leave(object sender, EventArgs e)
        {
            if (string.IsNullOrWhiteSpace(txtSearch.Text))
            {
                txtSearch.Text = SearchPlaceholder;
                txtSearch.ForeColor = Color.Gray;
            }
        }
    }
}
