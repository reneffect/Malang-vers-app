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
        }

        private void BindPaymentData()
        {
            if (payment == null) return;

            Text = "Digital Payment Proof Verification - " + payment.PembayaranId;
            statusPillLabel.Text = "Status: " + payment.PembayaranStatus;
            posTrxBox.Text = payment.PembayaranId;
            orderIdBox.Text = payment.TransaksiId;
            uploadTimeBox.Text = payment.PembayaranTanggal.HasValue
                ? payment.PembayaranTanggal.Value.ToString("dd MMMM yyyy HH:mm 'WIB'")
                : "Belum ada timestamp pembayaran";

            ebookNameLabel.Text = payment.JudulRingkas;
            ebookLicenseLabel.Text = "Akses: " + payment.EbookStatusAkses + " • Pembeli: " + payment.UserNama;
            ebookSkuLabel.Text = "ID E-Book: " + payment.EbookId + " • Status Pesanan: " + payment.TransaksiStatus;
            totalAmountLabel.Text = DatabaseService.FormatRupiah(payment.PembayaranJumlah);

            destAccountBox.Text = "MalangVerse Official Account";
            payMethodBox.Text = payment.PembayaranMetode;
            auditNoteBox.Text = string.IsNullOrWhiteSpace(payment.PembayaranReferensi)
                ? $"Pembayaran {payment.PembayaranMetode} sebesar {DatabaseService.FormatRupiah(payment.PembayaranJumlah)} oleh {payment.UserNama}."
                : payment.PembayaranReferensi;

            bankBadgeLabel.Text = payment.PembayaranMetode.ToUpperInvariant();
            transferHeaderLabel.Text = "Bukti Pembayaran " + payment.PembayaranMetode;
            transferDateLabel.Text = uploadTimeBox.Text;
            transferBodyLabel.Text =
                $"No. Referensi : {(string.IsNullOrWhiteSpace(payment.PembayaranReferensi) ? "-" : payment.PembayaranReferensi)}\r\n\r\n" +
                $"Nama Pembeli  : {payment.UserNama}\r\n\r\n" +
                $"ID Transaksi  : {payment.TransaksiId}\r\n\r\n" +
                $"Tagihan Order : {DatabaseService.FormatRupiah(payment.TransaksiGrandtotal)}";
            transferAmountLabel.Text = "Jumlah: " + DatabaseService.FormatRupiah(payment.PembayaranJumlah);
            transferSuccessBadge.Text = payment.PembayaranStatus.ToUpperInvariant();

            bool isNominalMatch = payment.PembayaranJumlah == payment.TransaksiGrandtotal;
            checkNominalLabel.Text = isNominalMatch
                ? $"✔ Nominal Cocok ({DatabaseService.FormatRupiah(payment.PembayaranJumlah)})"
                : $"⚠ Selisih Tagihan ({DatabaseService.FormatRupiah(payment.TransaksiGrandtotal)})";
            checkNominalLabel.ForeColor = isNominalMatch ? Color.FromArgb(22, 163, 74) : Color.FromArgb(217, 119, 6);

            bool hasRef = !string.IsNullOrWhiteSpace(payment.PembayaranReferensi);
            checkRefLabel.Text = hasRef ? $"✔ Ref: {payment.PembayaranReferensi}" : "⚠ Tanpa No. Referensi";
            checkRefLabel.ForeColor = hasRef ? Color.FromArgb(22, 163, 74) : Color.FromArgb(217, 119, 6);
        }

        private void ApproveBtn_Click(object sender, EventArgs e)
        {
            if (payment == null)
            {
                DialogResult = DialogResult.OK;
                Close();
                return;
            }

            try
            {
                DatabaseService.VerifyPayment(payment.PembayaranId, payment.TransaksiId, true, auditNoteBox.Text);
                MessageBox.Show("Pembayaran berhasil diverifikasi (Verified) dan status transaksi diperbarui menjadi Success.",
                    "Verifikasi Pembayaran", MessageBoxButtons.OK, MessageBoxIcon.Information);
                DialogResult = DialogResult.OK;
                Close();
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
                        MessageBox.Show("Pembayaran ditolak (Rejected) dengan alasan: " + reason.Reason,
                            "Verifikasi Pembayaran", MessageBoxButtons.OK, MessageBoxIcon.Warning);
                        DialogResult = DialogResult.OK;
                        Close();
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
            Close();
        }
    }
}
