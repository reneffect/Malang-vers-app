using System.ComponentModel;
using System.Drawing;
using System.Windows.Forms;

namespace dekstop
{
    partial class RejectionReasonForm
    {
        private IContainer components = null;
        private Panel headerPanel;
        private Label titleLabel;
        private Label descriptionLabel;
        private Panel editorPanel;
        private TextBox reasonBox;
        private Panel footerPanel;
        private Button cancelButton;
        private Button submitButton;

        protected override void Dispose(bool disposing)
        {
            if (disposing && components != null) components.Dispose();
            base.Dispose(disposing);
        }

        private void InitializeComponent()
        {
            this.components = new Container();
            this.headerPanel = new Panel();
            this.titleLabel = new Label();
            this.descriptionLabel = new Label();
            this.editorPanel = new Panel();
            this.reasonBox = new TextBox();
            this.footerPanel = new Panel();
            this.cancelButton = new Button();
            this.submitButton = new Button();
            this.headerPanel.SuspendLayout();
            this.editorPanel.SuspendLayout();
            this.footerPanel.SuspendLayout();
            this.SuspendLayout();

            this.headerPanel.BackColor = Color.White;
            this.headerPanel.Dock = DockStyle.Top;
            this.headerPanel.Height = 82;
            this.headerPanel.Padding = new Padding(20, 12, 20, 8);
            this.headerPanel.Controls.Add(this.descriptionLabel);
            this.headerPanel.Controls.Add(this.titleLabel);

            this.titleLabel.AutoSize = true;
            this.titleLabel.Font = new Font("Segoe UI", 12F, FontStyle.Bold);
            this.titleLabel.ForeColor = Color.FromArgb(37, 49, 68);
            this.titleLabel.Location = new Point(20, 13);
            this.titleLabel.Text = "Alasan Penolakan Pembayaran";

            this.descriptionLabel.AutoSize = true;
            this.descriptionLabel.Font = new Font("Segoe UI", 8.5F);
            this.descriptionLabel.ForeColor = Color.FromArgb(100, 116, 139);
            this.descriptionLabel.Location = new Point(22, 44);
            this.descriptionLabel.Text = "Tuliskan alasan agar dapat disampaikan kepada pembeli.";

            this.editorPanel.Dock = DockStyle.Fill;
            this.editorPanel.Padding = new Padding(20);
            this.editorPanel.BackColor = Color.FromArgb(244, 246, 250);
            this.editorPanel.Controls.Add(this.reasonBox);

            this.reasonBox.Dock = DockStyle.Fill;
            this.reasonBox.Multiline = true;
            this.reasonBox.ScrollBars = ScrollBars.Vertical;
            this.reasonBox.Font = new Font("Segoe UI", 10F);
            this.reasonBox.BorderStyle = BorderStyle.FixedSingle;
            this.reasonBox.Name = "reasonBox";

            this.footerPanel.Dock = DockStyle.Bottom;
            this.footerPanel.Height = 62;
            this.footerPanel.BackColor = Color.White;
            this.footerPanel.Padding = new Padding(12);
            this.footerPanel.Controls.Add(this.submitButton);
            this.footerPanel.Controls.Add(this.cancelButton);

            this.submitButton.Text = "Kirim Penolakan";
            this.submitButton.Size = new Size(132, 34);
            this.submitButton.Dock = DockStyle.Right;
            this.submitButton.BackColor = Color.FromArgb(43, 91, 226);
            this.submitButton.ForeColor = Color.White;
            this.submitButton.FlatStyle = FlatStyle.Flat;
            this.submitButton.FlatAppearance.BorderSize = 0;
            this.submitButton.Font = new Font("Segoe UI", 9F, FontStyle.Bold);
            this.submitButton.Click += new System.EventHandler(this.SubmitButton_Click);

            this.cancelButton.Text = "Batal";
            this.cancelButton.Size = new Size(82, 34);
            this.cancelButton.Dock = DockStyle.Right;
            this.cancelButton.Margin = new Padding(0, 0, 8, 0);
            this.cancelButton.FlatStyle = FlatStyle.Flat;
            this.cancelButton.FlatAppearance.BorderColor = Color.FromArgb(203, 213, 225);
            this.cancelButton.Click += new System.EventHandler(this.CancelButton_Click);

            this.AutoScaleDimensions = new SizeF(7F, 15F);
            this.AutoScaleMode = AutoScaleMode.Font;
            this.BackColor = Color.FromArgb(244, 246, 250);
            this.ClientSize = new Size(480, 300);
            this.Controls.Add(this.editorPanel);
            this.Controls.Add(this.footerPanel);
            this.Controls.Add(this.headerPanel);
            this.Font = new Font("Segoe UI", 9F);
            this.FormBorderStyle = FormBorderStyle.FixedDialog;
            this.MaximizeBox = false;
            this.MinimizeBox = false;
            this.Name = "RejectionReasonForm";
            this.StartPosition = FormStartPosition.CenterParent;
            this.Text = "Alasan Penolakan";
            this.headerPanel.ResumeLayout(false);
            this.headerPanel.PerformLayout();
            this.editorPanel.ResumeLayout(false);
            this.editorPanel.PerformLayout();
            this.footerPanel.ResumeLayout(false);
            this.ResumeLayout(false);
        }
    }
}
