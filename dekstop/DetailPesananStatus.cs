using System;
using System.Drawing;
using System.Linq;
using System.Windows.Forms;

namespace dekstop
{
    public partial class DetailPesananStatus : UserControl
    {
        public DetailPesananStatus()
        {
            InitializeComponent();
            updateGroupBox.Visible = false;
        }

        public void SetOrderDetail(string title, string format, string paymentMethod, string total)
        {
            itemTitleValue.Text = string.IsNullOrWhiteSpace(title) ? "-" : title;

            // Ukur tinggi aktual teks judul agar multi-buku (4+ judul) tidak terpotong di baris terbawah.
            int availWidth = Math.Max(180, detailGroupBox.ClientSize.Width - 28);
            itemTitleValue.Width = availWidth;
            Size measured = TextRenderer.MeasureText(
                itemTitleValue.Text,
                itemTitleValue.Font,
                new Size(availWidth, int.MaxValue),
                TextFormatFlags.WordBreak | TextFormatFlags.TextBoxControl);
            itemTitleValue.Height = Math.Max(24, measured.Height + 6);

            formatCaption.Location = new Point(14, itemTitleValue.Bottom + 8);
            formatValue.Location = new Point(14, formatCaption.Bottom + 1);
            formatValue.Height = 22;
            formatValue.Width = Math.Max(110, (detailGroupBox.ClientSize.Width - 42) / 2);

            methodCaption.Location = new Point(formatValue.Right + 12, formatCaption.Top);
            methodValue.Location = new Point(methodCaption.Left, formatValue.Top);
            methodValue.Height = 22;
            methodValue.Width = Math.Max(100, detailGroupBox.ClientSize.Width - methodValue.Left - 18);

            totalBillBox.Anchor = AnchorStyles.Top | AnchorStyles.Left | AnchorStyles.Right;
            totalBillBox.Location = new Point(14, formatValue.Bottom + 8);
            totalBillBox.Width = detailGroupBox.ClientSize.Width - 28;
            totalBillBox.Height = 27;
            totalBillCaption.Location = new Point(6, 5);
            totalBillValue.Location = new Point(Math.Max(90, totalBillBox.Width - 180), 4);
            totalBillValue.Width = 174;

            detailGroupBox.Height = totalBillBox.Bottom + 14;
            formatValue.Text = string.IsNullOrWhiteSpace(format) ? "-" : format;
            methodValue.Text = string.IsNullOrWhiteSpace(paymentMethod) ? "QRIS" : paymentMethod;
            totalBillValue.Text = string.IsNullOrWhiteSpace(total) ? "Rp 0" : total;

            Height = detailGroupBox.Bottom + 6;
        }

    }
}
