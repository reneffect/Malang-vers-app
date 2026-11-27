using System;
using System.Drawing;
using System.Windows.Forms;

namespace dekstop
{
    public partial class PaymentDetailForm : Form
    {
        private readonly PembayaranModel payment;

        public PaymentDetailForm() : this(null)
        {
        }

        public PaymentDetailForm(PembayaranModel model)
        {
            payment = model;
            InitializeComponent();
            BindPaymentData();
            ApplyActionVisibility();
        }

        private void ApplyActionVisibility()
        {
            bool canReview = payment != null &&
                string.Equals(payment.PembayaranStatus, "Pending", StringComparison.OrdinalIgnoreCase);
            approveBtn.Visible = canReview;
            rejectBtn.Visible = canReview;
            closeBtn.Visible = true;
            closeBtn.Text = "Tutup / Kembali";
        }

        private void CompleteReview(string paymentStatus, string transactionStatus)
        {
            payment.PembayaranStatus = paymentStatus;
            payment.TransaksiStatus = transactionStatus;
            UpdateStatusDisplays(paymentStatus);
            ApplyActionVisibility();
            MessageBox.Show(paymentStatus == "Verified"
                    ? "Pembayaran berhasil diverifikasi. Status transaksi menjadi Success."
                    : "Pembayaran berhasil ditolak. Status transaksi menjadi Canceled.",
                "Verifikasi Pembayaran", MessageBoxButtons.OK, MessageBoxIcon.Information);
        }

        private void UpdateStatusDisplays(string status)
        {
            if (string.Equals(status, "Verified", StringComparison.OrdinalIgnoreCase))
            {
                statusPillLabel.Text = "Status: Terverifikasi";
                statusPillLabel.BackColor = Color.FromArgb(220, 252, 231);
                statusPillLabel.ForeColor = Color.FromArgb(21, 128, 61);
            }
            else if (string.Equals(status, "Rejected", StringComparison.OrdinalIgnoreCase))
            {
                statusPillLabel.Text = "Status: Ditolak";
                statusPillLabel.BackColor = Color.FromArgb(254, 226, 226);
                statusPillLabel.ForeColor = Color.FromArgb(185, 28, 28);
            }
            else
            {
                statusPillLabel.Text = "Status: Menunggu Konfirmasi Kasir";
                statusPillLabel.BackColor = Color.FromArgb(238, 242, 255);
                statusPillLabel.ForeColor = Color.FromArgb(37, 99, 235);
            }
        }

        private void BindPaymentData()
        {
            if (payment == null) return;

            Text = "Digital Payment Proof Verification - " + payment.PembayaranId;
            UpdateStatusDisplays(payment.PembayaranStatus);
            posTrxBox.Text = payment.PembayaranId;
            orderIdBox.Text = payment.TransaksiId;

            ebookNameLabel.Text = payment.JudulRingkas;
            ebookNameLabel.AutoSize = false;
            int nameWidth = Math.Max(220, itemSummaryBox.ClientSize.Width - 170);
            ebookNameLabel.Width = nameWidth;
            Size nameSize = TextRenderer.MeasureText(
                ebookNameLabel.Text,
                ebookNameLabel.Font,
                new Size(nameWidth, int.MaxValue),
                TextFormatFlags.WordBreak | TextFormatFlags.TextBoxControl);
            ebookNameLabel.Height = Math.Max(24, nameSize.Height + 4);

            ebookLicenseLabel.Text = "Akses: " + payment.EbookStatusAkses + " • Pembeli: " + payment.UserNama;
            ebookLicenseLabel.Top = ebookNameLabel.Bottom + 4;

            ebookSkuLabel.Text = "ID E-Book: " + payment.EbookId + " • Status Pesanan: " + payment.TransaksiStatus;
            ebookSkuLabel.Top = ebookLicenseLabel.Bottom + 4;

            itemSummaryBox.Height = Math.Max(118, ebookSkuLabel.Bottom + 14);
            destAccountCaption.Top = itemSummaryBox.Bottom + 16;
            payMethodCaption.Top = destAccountCaption.Top;
            destAccountBox.Top = destAccountCaption.Bottom + 4;
            payMethodBox.Top = destAccountBox.Top;
            itemDetailGroup.Height = destAccountBox.Bottom + 18;

            totalAmountLabel.Text = DatabaseService.FormatRupiah(payment.PembayaranJumlah);

            destAccountBox.Text = "BCA 123-456-7890 (MalangVerse)";
            payMethodBox.Text = payment.PembayaranMetode;

        }

        private void ApproveBtn_Click(object sender, EventArgs e)
        {
            if (payment == null) return;
            if (!string.Equals(payment.PembayaranStatus, "Pending", StringComparison.OrdinalIgnoreCase))
            {
                ApplyActionVisibility();
                return;
            }

            DialogResult confirm = MessageBox.Show(
                "Apakah Anda yakin ingin menyetujui dan memverifikasi pembayaran ini?\r\n\r\n" +
                "Setelah disetujui, status transaksi akan berubah menjadi Success dan tindakan ini tidak dapat dibatalkan dari halaman ini.",
                "Konfirmasi Kedua - Approve Pembayaran",
                MessageBoxButtons.YesNo, MessageBoxIcon.Warning, MessageBoxDefaultButton.Button2);
            if (confirm != DialogResult.Yes) return;

            try
            {
                DatabaseService.VerifyPayment(payment.PembayaranId, payment.TransaksiId, true, payment.PembayaranReferensi ?? string.Empty);
                CompleteReview("Verified", "Success");
            }
            catch (Exception ex)
            {
                MessageBox.Show("Gagal memverifikasi pembayaran:\n" + ex.Message,
                    "Kesalahan Database", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void RejectBtn_Click(object sender, EventArgs e)
        {
            using (RejectionReasonForm reason = new RejectionReasonForm())
            {
                if (reason.ShowDialog(this) == DialogResult.OK)
                {
                    if (payment == null)
                    {
                        DialogResult = DialogResult.Cancel;
                        Close();
                        return;
                    }

                    try
                    {
                        DatabaseService.VerifyPayment(payment.PembayaranId, payment.TransaksiId, false, reason.Reason);
                        CompleteReview("Rejected", "Canceled");
                    }
                    catch (Exception ex)
                    {
                        MessageBox.Show("Gagal menyimpan penolakan pembayaran:\n" + ex.Message,
                            "Kesalahan Database", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    }
                }
            }
        }

        private void CloseBtn_Click(object sender, EventArgs e)
        {
            DialogResult = DialogResult.OK;
            Close();
        }
    }
}
