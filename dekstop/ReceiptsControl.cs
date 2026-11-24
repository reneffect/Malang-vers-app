using System;
using System.Collections.Generic;
using System.Drawing;
using System.Linq;
using System.Windows.Forms;

namespace dekstop
{
    public partial class ReceiptsControl : UserControl
    {
        private List<TransaksiSummaryModel> completedTransactions = new List<TransaksiSummaryModel>();
        private int currentPage = 1;
        private const int PageSize = 5;

        public ReceiptsControl()
        {
            InitializeComponent();
            searchReceiptBox.Text = string.Empty;

            firstPageBtn.Click += (_, __) => { currentPage = 1; RenderPage(); };
            prevPageBtn.Click += (_, __) => { if (currentPage > 1) { currentPage--; RenderPage(); } };
            nextPageBtn.Click += (_, __) =>
            {
                int maxPage = Math.Max(1, (int)Math.Ceiling(completedTransactions.Count / (double)PageSize));
                if (currentPage < maxPage) { currentPage++; RenderPage(); }
            };
            lastPageBtn.Click += (_, __) =>
            {
                currentPage = Math.Max(1, (int)Math.Ceiling(completedTransactions.Count / (double)PageSize));
                RenderPage();
            };

            if (!DatabaseService.IsDesignMode())
            {
                LoadReceiptsFromDb();
            }
        }

        private void LoadReceiptsFromDb(string keyword = "")
        {
            try
            {
                completedTransactions = DatabaseService.GetTransactions(keyword, "Success");
                currentPage = 1;
                RenderPage();
            }
            catch (Exception ex)
            {
                MessageBox.Show("Gagal memuat arsip kwitansi:\n" + ex.Message,
                    "Database Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void RenderPage()
        {
            receiptsGrid.Rows.Clear();
            int totalRecords = completedTransactions.Count;
            int totalPages = Math.Max(1, (int)Math.Ceiling(totalRecords / (double)PageSize));
            if (currentPage > totalPages) currentPage = totalPages;

            var pageItems = completedTransactions
                .Skip((currentPage - 1) * PageSize)
                .Take(PageSize)
                .ToList();

            int startIdx = (currentPage - 1) * PageSize;
            for (int i = 0; i < pageItems.Count; i++)
            {
                var trx = pageItems[i];
                int seq = startIdx + i + 1;
                string kwtNo = "KWT-" + trx.TransaksiId;
                string dateStr = (trx.PembayaranTanggal ?? trx.TransaksiTanggal).ToString("dd/MM/yyyy HH:mm");
                string totalStr = DatabaseService.FormatRupiah(trx.TransaksiGrandtotal);

                AddReceiptRow(seq.ToString("00"), kwtNo, trx, dateStr, totalStr, "LUNAS", "", i == 0);
            }

            countBadgeLabel.Text = $"{totalRecords} Selesai";
            pageNumberLabel.Text = $"Halaman {currentPage} / {totalPages}";
            int fromNum = totalRecords == 0 ? 0 : startIdx + 1;
            int toNum = startIdx + pageItems.Count;
            paginationSummaryLabel.Text = $"Menampilkan {fromNum} - {toNum} dari {totalRecords} Kwitansi Transaksi Selesai";

            if (receiptsGrid.Rows.Count > 0)
            {
                receiptsGrid.Rows[0].Selected = true;
            }
        }

        private void AddReceiptRow(string no, string kwt, TransaksiSummaryModel trx, string date, string total, string status, string actionLabel, bool highlight)
        {
            int idx = receiptsGrid.Rows.Add(no, kwt, trx.TransaksiId, trx.JudulRingkas, date, total, status, actionLabel, "🖨");
            DataGridViewRow row = receiptsGrid.Rows[idx];
            row.Tag = trx;
            row.Cells[1].Style.Font = new Font("Georgia", 8.25F, FontStyle.Bold);
            if (highlight)
            {
                row.Cells[0].Style.ForeColor = Color.FromArgb(37, 99, 235);
                row.Cells[0].Style.Font = new Font("Georgia", 8.25F, FontStyle.Bold);
                row.Cells[1].Style.ForeColor = Color.FromArgb(37, 99, 235);
            }
        }

        private void ReceiptsGrid_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {
            if (e.RowIndex >= 0 && e.ColumnIndex == 8)
            {
                PrintReceiptDirect(e.RowIndex);
            }
        }


        private void PrintReceiptDirect(int rowIndex)
        {
            if (rowIndex < 0 || !(receiptsGrid.Rows[rowIndex].Tag is TransaksiSummaryModel trx)) return;
            // Tampilkan preview struk terlebih dahulu; pencetakan dilakukan dari tombol
            // "Cetak Sekarang" di dalam jendela preview.
            using (ReceiptDetailForm receipt = new ReceiptDetailForm(trx.TransaksiId))
            {
                receipt.ShowDialog(this);
            }
        }

        private void SearchReceiptBox_TextChanged(object sender, EventArgs e)
        {
            if (DatabaseService.IsDesignMode()) return;
            string q = searchReceiptBox.Text.Trim();
            if (q == "Search by Receipt ID / Name...") return;
            LoadReceiptsFromDb(q);
        }
    }
}
