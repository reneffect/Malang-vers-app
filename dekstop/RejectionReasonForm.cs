using System;
using System.Windows.Forms;

namespace dekstop
{
    public partial class RejectionReasonForm : Form
    {
        public string Reason
        {
            get { return reasonBox == null ? string.Empty : reasonBox.Text.Trim(); }
        }

        public RejectionReasonForm()
        {
            InitializeComponent();
        }

        private void SubmitButton_Click(object sender, EventArgs e)
        {
            if (string.IsNullOrWhiteSpace(Reason))
            {
                MessageBox.Show("Alasan penolakan wajib diisi.", "Validasi",
                    MessageBoxButtons.OK, MessageBoxIcon.Warning);
                reasonBox.Focus();
                return;
            }

            DialogResult = DialogResult.OK;
            Close();
        }

        private void CancelButton_Click(object sender, EventArgs e)
        {
            DialogResult = DialogResult.Cancel;
            Close();
        }
    }
}
