using System;
using System.Collections.Generic;
using System.Drawing;
using System.Linq;
using System.Windows.Forms;

namespace dekstop
{
    public partial class ManagePaymentsControl : UserControl
    {
        public ManagePaymentsControl()
        {
            InitializeComponent();
            searchOrderBox.Text = string.Empty;
            if (!DatabaseService.IsDesignMode())
            {
                LoadPaymentsFromDb();
            }
        }

        private void LoadPaymentsFromDb(string keyword = "")
        {
            try
            {
                List<PembayaranModel> list = DatabaseService.GetPayments(keyword);
                paymentsGrid.Rows.Clear();

                int pendingCount = 0;
                int no = 1;
                foreach (var p in list)
                {
                    bool isPending = p.PembayaranStatus.Equals("Pending", StringComparison.OrdinalIgnoreCase);
                    if (isPending) pendingCount++;

                    string timeStr = p.PembayaranTanggal.HasValue
                        ? p.PembayaranTanggal.Value.ToString("dd MMM yyyy HH:mm")
                        : "-";
                    string statusLabel = isPending ? "Menunggu Verifikasi"
                        : p.PembayaranStatus.Equals("Verified", StringComparison.OrdinalIgnoreCase) ? "Terverifikasi"
                        : p.PembayaranStatus.Equals("Rejected", StringComparison.OrdinalIgnoreCase) ? "Ditolak"
                        : p.PembayaranStatus;

                    AddPaymentRow(
                        no.ToString(),
                        p,
                        DatabaseService.FormatRupiah(p.PembayaranJumlah),
                        timeStr,
                        statusLabel,
                        isPending ? "Buka" : "Detail"
                    );
                    no++;
                }

                pendingBadgeLabel.Text = $"{pendingCount} Menunggu Persetujuan";
                if (paymentsGrid.Rows.Count > 0)
                {
                    paymentsGrid.Rows[0].Selected = true;
                }
            }
            catch (Exception ex)
            {
                MessageBox.Show("Gagal memuat daftar pembayaran:\n" + ex.Message,
                    "Database Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void AddPaymentRow(string no, PembayaranModel p, string total, string time, string status, string actionText)
        {
            int idx = paymentsGrid.Rows.Add(no, p.PembayaranId, p.TransaksiId, $"{p.JudulRingkas} ({p.PembayaranMetode})", total, time, status, actionText);
            DataGridViewRow row = paymentsGrid.Rows[idx];
            row.Tag = p;

            DataGridViewCell statusCell = row.Cells[6];
            if (status == "Menunggu Verifikasi")
            {
                statusCell.Style.BackColor = Color.FromArgb(255, 247, 237);
                statusCell.Style.ForeColor = Color.FromArgb(194, 65, 12);
            }
            else if (status == "Terverifikasi")
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

        private void PaymentsGrid_CellContentClick(object sender, DataGridViewCellEventArgs e)
        {
            if (e.RowIndex >= 0 && e.ColumnIndex == 7)
            {
                OpenPaymentDetail(e.RowIndex);
            }
        }

        private void PaymentsGrid_CellDoubleClick(object sender, DataGridViewCellEventArgs e)
        {
            if (e.RowIndex >= 0)
            {
                OpenPaymentDetail(e.RowIndex);
            }
        }

        private void OpenPaymentDetail(int rowIndex)
        {
            if (rowIndex < 0 || !(paymentsGrid.Rows[rowIndex].Tag is PembayaranModel p)) return;
            using (PaymentDetailForm dialog = new PaymentDetailForm(p))
            {
                if (dialog.ShowDialog(FindForm()) == DialogResult.OK)
                {
                    LoadPaymentsFromDb(searchOrderBox.Text);
                }
            }
        }

        private void SearchOrderBox_TextChanged(object sender, EventArgs e)
        {
            if (DatabaseService.IsDesignMode()) return;
            LoadPaymentsFromDb(searchOrderBox.Text);
        }
    }
}
