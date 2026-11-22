using System;
using System.Drawing;
using System.Windows.Forms;

namespace dekstop
{
    public partial class DetailPesananStatus : UserControl
    {
        private const string NotePlaceholder = "Tulis catatan jika ada pengembalian atau manual check...";

        public DetailPesananStatus()
        {
            InitializeComponent();
            orderStatusCombo.SelectedIndex = 0;
            cashierNoteBox.Enter += CashierNoteBox_Enter;
            cashierNoteBox.Leave += CashierNoteBox_Leave;
        }

        public int SelectedStatusIndex
        {
            get => orderStatusCombo.SelectedIndex;
            set => orderStatusCombo.SelectedIndex = value;
        }

        public string CashierNote
        {
            get => cashierNoteBox.Text == NotePlaceholder ? string.Empty : cashierNoteBox.Text.Trim();
            set
            {
                cashierNoteBox.Text = string.IsNullOrWhiteSpace(value) ? NotePlaceholder : value;
                cashierNoteBox.ForeColor = string.IsNullOrWhiteSpace(value)
                    ? Color.FromArgb(100, 116, 139)
                    : Color.FromArgb(30, 41, 59);
            }
        }

        public void SetOrderDetail(string title, string format, string paymentMethod, string total)
        {
            itemTitleValue.Text = string.IsNullOrWhiteSpace(title) ? "-" : title;
            formatValue.Text = string.IsNullOrWhiteSpace(format) ? "-" : format;
            methodValue.Text = string.IsNullOrWhiteSpace(paymentMethod) ? "QRIS" : paymentMethod;
            totalBillValue.Text = string.IsNullOrWhiteSpace(total) ? "Rp 0" : total;
        }

        public void SetStatusFromText(string status)
        {
            if (string.Equals(status, "Success", StringComparison.OrdinalIgnoreCase))
                SelectedStatusIndex = 1;
            else if (string.Equals(status, "Canceled", StringComparison.OrdinalIgnoreCase))
                SelectedStatusIndex = 2;
            else
                SelectedStatusIndex = 0;
        }

        private void CashierNoteBox_Enter(object sender, EventArgs e)
        {
            if (cashierNoteBox.Text == NotePlaceholder)
            {
                cashierNoteBox.Text = string.Empty;
                cashierNoteBox.ForeColor = Color.FromArgb(30, 41, 59);
            }
        }

        private void CashierNoteBox_Leave(object sender, EventArgs e)
        {
            if (string.IsNullOrWhiteSpace(cashierNoteBox.Text))
                CashierNote = string.Empty;
        }
    }
}
