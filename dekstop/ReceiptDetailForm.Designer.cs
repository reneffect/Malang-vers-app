using System.ComponentModel;
using System.Drawing;
using System.Windows.Forms;

namespace dekstop
{
    partial class ReceiptDetailForm
    {
        private IContainer components = null;
        private Panel topBar;
        private Button savePdfBtn;
        private Button zoomOutBtn;
        private Label zoomPercentLabel;
        private Button zoomInBtn;
        private Panel viewerCanvas;
        private Panel paperContainer;
        private Panel bottomBar;
        private Button printNowBtn;
        private Button closeBtn;

        protected override void Dispose(bool disposing)
        {
            if (disposing && components != null) components.Dispose();
            base.Dispose(disposing);
        }

        private void InitializeComponent()
        {
            this.components = new Container();
            this.topBar = new Panel();
            this.savePdfBtn = new Button();
            this.zoomOutBtn = new Button();
            this.zoomPercentLabel = new Label();
            this.zoomInBtn = new Button();
            this.viewerCanvas = new Panel();
            this.paperContainer = new Panel();
            this.bottomBar = new Panel();
            this.printNowBtn = new Button();
            this.closeBtn = new Button();
            this.topBar.SuspendLayout();
            this.viewerCanvas.SuspendLayout();
            this.bottomBar.SuspendLayout();
            this.SuspendLayout();
            // topBar
            this.topBar.BackColor = Color.White;
            this.topBar.Dock = DockStyle.Top;
            this.topBar.Height = 42;
            this.topBar.Padding = new Padding(16, 5, 16, 5);
            this.topBar.Paint += new PaintEventHandler(this.TopBar_Paint);
            this.topBar.Controls.Add(this.savePdfBtn);
            this.topBar.Controls.Add(this.zoomOutBtn);
            this.topBar.Controls.Add(this.zoomPercentLabel);
            this.topBar.Controls.Add(this.zoomInBtn);
            // savePdfBtn
            this.savePdfBtn.Text = "Simpan PDF";
            this.savePdfBtn.Size = new Size(108, 30);
            this.savePdfBtn.Location = new Point(20, 6);
            this.savePdfBtn.BackColor = Color.White;
            this.savePdfBtn.ForeColor = Color.FromArgb(30, 41, 59);
            this.savePdfBtn.Font = new Font("Georgia", 8.5F, FontStyle.Bold);
            this.savePdfBtn.FlatStyle = FlatStyle.Flat;
            this.savePdfBtn.FlatAppearance.BorderColor = Color.FromArgb(203, 213, 225);
            this.savePdfBtn.Cursor = Cursors.Hand;
            this.savePdfBtn.Click += new System.EventHandler(this.SavePdfButton_Click);
            // zoomOutBtn
            this.zoomOutBtn.Text = "Zoom -";
            this.zoomOutBtn.Size = new Size(56, 28);
            this.zoomOutBtn.Anchor = AnchorStyles.Top | AnchorStyles.Right;
            this.zoomOutBtn.Location = new Point(560, 7);
            this.zoomOutBtn.BackColor = Color.White;
            this.zoomOutBtn.ForeColor = Color.FromArgb(51, 65, 85);
            this.zoomOutBtn.Font = new Font("Segoe UI", 8.5F, FontStyle.Bold);
            this.zoomOutBtn.FlatStyle = FlatStyle.Flat;
            this.zoomOutBtn.FlatAppearance.BorderColor = Color.FromArgb(203, 213, 225);
            this.zoomOutBtn.Click += new System.EventHandler(this.ZoomOutButton_Click);
            // zoomPercentLabel
            this.zoomPercentLabel.Text = "100%";
            this.zoomPercentLabel.Size = new Size(54, 28);
            this.zoomPercentLabel.Anchor = AnchorStyles.Top | AnchorStyles.Right;
            this.zoomPercentLabel.Location = new Point(620, 7);
            this.zoomPercentLabel.Font = new Font("Georgia", 8.5F, FontStyle.Bold);
            this.zoomPercentLabel.ForeColor = Color.FromArgb(30, 41, 59);
            this.zoomPercentLabel.TextAlign = ContentAlignment.MiddleCenter;
            // zoomInBtn
            this.zoomInBtn.Text = "Zoom +";
            this.zoomInBtn.Size = new Size(56, 28);
            this.zoomInBtn.Anchor = AnchorStyles.Top | AnchorStyles.Right;
            this.zoomInBtn.Location = new Point(678, 7);
            this.zoomInBtn.BackColor = Color.White;
            this.zoomInBtn.ForeColor = Color.FromArgb(51, 65, 85);
            this.zoomInBtn.Font = new Font("Segoe UI", 8.5F, FontStyle.Bold);
            this.zoomInBtn.FlatStyle = FlatStyle.Flat;
            this.zoomInBtn.FlatAppearance.BorderColor = Color.FromArgb(203, 213, 225);
            this.zoomInBtn.Click += new System.EventHandler(this.ZoomInButton_Click);
            // viewerCanvas
            this.viewerCanvas.Dock = DockStyle.Fill;
            this.viewerCanvas.BackColor = Color.FromArgb(67, 79, 98);
            this.viewerCanvas.AutoScroll = true;
            this.viewerCanvas.Resize += new System.EventHandler(this.ViewerCanvas_Resize);
            this.viewerCanvas.Controls.Add(this.paperContainer);
            // paperContainer
            this.paperContainer.BackColor = Color.White;
            this.paperContainer.Location = new Point(180, 26);
            this.paperContainer.Size = new Size(420, 752);
            this.paperContainer.Paint += new PaintEventHandler(this.PaperContainer_Paint);
            // bottomBar
            this.bottomBar.Dock = DockStyle.Bottom;
            this.bottomBar.Height = 46;
            this.bottomBar.BackColor = Color.White;
            this.bottomBar.Paint += new PaintEventHandler(this.BottomBar_Paint);
            this.bottomBar.Controls.Add(this.printNowBtn);
            this.bottomBar.Controls.Add(this.closeBtn);
            // printNowBtn
            this.printNowBtn.Text = "Cetak Sekarang";
            this.printNowBtn.Size = new Size(153, 28);
            this.printNowBtn.Anchor = AnchorStyles.Top | AnchorStyles.Right;
            this.printNowBtn.Location = new Point(490, 9);
            this.printNowBtn.BackColor = Color.FromArgb(37, 99, 235);
            this.printNowBtn.ForeColor = Color.White;
            this.printNowBtn.Font = new Font("Georgia", 8.5F, FontStyle.Bold);
            this.printNowBtn.FlatStyle = FlatStyle.Flat;
            this.printNowBtn.FlatAppearance.BorderSize = 0;
            this.printNowBtn.Click += new System.EventHandler(this.PrintNowButton_Click);
            // closeBtn
            this.closeBtn.Text = "Tutup";
            this.closeBtn.Size = new Size(70, 28);
            this.closeBtn.Anchor = AnchorStyles.Top | AnchorStyles.Right;
            this.closeBtn.Location = new Point(650, 9);
            this.closeBtn.BackColor = Color.White;
            this.closeBtn.ForeColor = Color.FromArgb(30, 41, 59);
            this.closeBtn.Font = new Font("Georgia", 8.5F, FontStyle.Bold);
            this.closeBtn.FlatStyle = FlatStyle.Flat;
            this.closeBtn.FlatAppearance.BorderColor = Color.FromArgb(203, 213, 225);
            this.closeBtn.Click += new System.EventHandler(this.CloseButton_Click);
            // ReceiptDetailForm
            this.AutoScaleDimensions = new SizeF(7F, 15F);
            this.AutoScaleMode = AutoScaleMode.Font;
            this.BackColor = Color.FromArgb(67, 79, 98);
            this.ClientSize = new Size(780, 880);
            this.MinimumSize = new Size(680, 560);
            this.Controls.Add(this.viewerCanvas);
            this.Controls.Add(this.topBar);
            this.Controls.Add(this.bottomBar);
            this.Name = "ReceiptDetailForm";
            this.StartPosition = FormStartPosition.CenterParent;
            this.Text = "Preview Struk";
            this.topBar.ResumeLayout(false);
            this.viewerCanvas.ResumeLayout(false);
            this.bottomBar.ResumeLayout(false);
            this.ResumeLayout(false);
        }
    }
}
