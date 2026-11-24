namespace dekstop
{
    partial class DetailPesananStatus
    {
        private System.ComponentModel.IContainer components = null;
        private System.Windows.Forms.GroupBox detailGroupBox;
        private System.Windows.Forms.Label itemTitleCaption;
        private System.Windows.Forms.Label itemTitleValue;
        private System.Windows.Forms.Label formatCaption;
        private System.Windows.Forms.Label formatValue;
        private System.Windows.Forms.Label methodCaption;
        private System.Windows.Forms.Label methodValue;
        private System.Windows.Forms.Panel totalBillBox;
        private System.Windows.Forms.Label totalBillCaption;
        private System.Windows.Forms.Label totalBillValue;
        private System.Windows.Forms.GroupBox updateGroupBox;
        private System.Windows.Forms.Label currentStatusCaption;
        private System.Windows.Forms.ComboBox orderStatusCombo;
        private System.Windows.Forms.Label noteCaption;
        private System.Windows.Forms.TextBox cashierNoteBox;

        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null)) components.Dispose();
            base.Dispose(disposing);
        }

        private void InitializeComponent()
        {
            this.detailGroupBox = new System.Windows.Forms.GroupBox();
            this.totalBillBox = new System.Windows.Forms.Panel();
            this.totalBillValue = new System.Windows.Forms.Label();
            this.totalBillCaption = new System.Windows.Forms.Label();
            this.methodValue = new System.Windows.Forms.Label();
            this.methodCaption = new System.Windows.Forms.Label();
            this.formatValue = new System.Windows.Forms.Label();
            this.formatCaption = new System.Windows.Forms.Label();
            this.itemTitleValue = new System.Windows.Forms.Label();
            this.itemTitleCaption = new System.Windows.Forms.Label();
            this.updateGroupBox = new System.Windows.Forms.GroupBox();
            this.cashierNoteBox = new System.Windows.Forms.TextBox();
            this.noteCaption = new System.Windows.Forms.Label();
            this.orderStatusCombo = new System.Windows.Forms.ComboBox();
            this.currentStatusCaption = new System.Windows.Forms.Label();
            this.detailGroupBox.SuspendLayout();
            this.totalBillBox.SuspendLayout();
            this.updateGroupBox.SuspendLayout();
            this.SuspendLayout();
            // 
            // detailGroupBox
            // 
            this.detailGroupBox.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.detailGroupBox.BackColor = System.Drawing.Color.White;
            this.detailGroupBox.Controls.Add(this.totalBillBox);
            this.detailGroupBox.Controls.Add(this.methodValue);
            this.detailGroupBox.Controls.Add(this.methodCaption);
            this.detailGroupBox.Controls.Add(this.formatValue);
            this.detailGroupBox.Controls.Add(this.formatCaption);
            this.detailGroupBox.Controls.Add(this.itemTitleValue);
            this.detailGroupBox.Controls.Add(this.itemTitleCaption);
            this.detailGroupBox.Font = new System.Drawing.Font("Georgia", 8.25F, System.Drawing.FontStyle.Bold);
            this.detailGroupBox.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(51)))), ((int)(((byte)(65)))), ((int)(((byte)(85)))));
            this.detailGroupBox.Location = new System.Drawing.Point(0, 0);
            this.detailGroupBox.Name = "detailGroupBox";
            this.detailGroupBox.Padding = new System.Windows.Forms.Padding(10);
            this.detailGroupBox.Size = new System.Drawing.Size(366, 210);
            this.detailGroupBox.TabIndex = 0;
            this.detailGroupBox.TabStop = false;
            this.detailGroupBox.Text = "Ringkasan Pesanan";
            // 
            // totalBillBox
            // 
            this.totalBillBox.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.totalBillBox.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(239)))), ((int)(((byte)(246)))), ((int)(((byte)(255)))));
            this.totalBillBox.Controls.Add(this.totalBillValue);
            this.totalBillBox.Controls.Add(this.totalBillCaption);
            this.totalBillBox.Location = new System.Drawing.Point(14, 177);
            this.totalBillBox.Name = "totalBillBox";
            this.totalBillBox.Size = new System.Drawing.Size(326, 27);
            this.totalBillBox.TabIndex = 6;
            // 
            // totalBillValue
            // 
            this.totalBillValue.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.totalBillValue.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.totalBillValue.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(64)))), ((int)(((byte)(175)))));
            this.totalBillValue.Location = new System.Drawing.Point(145, 4);
            this.totalBillValue.Name = "totalBillValue";
            this.totalBillValue.Size = new System.Drawing.Size(174, 19);
            this.totalBillValue.TabIndex = 1;
            this.totalBillValue.Text = "Rp 0";
            this.totalBillValue.TextAlign = System.Drawing.ContentAlignment.MiddleRight;
            // 
            // totalBillCaption
            // 
            this.totalBillCaption.AutoSize = true;
            this.totalBillCaption.Font = new System.Drawing.Font("Segoe UI", 8F, System.Drawing.FontStyle.Bold);
            this.totalBillCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(64)))), ((int)(((byte)(175)))));
            this.totalBillCaption.Location = new System.Drawing.Point(6, 5);
            this.totalBillCaption.Name = "totalBillCaption";
            this.totalBillCaption.Size = new System.Drawing.Size(98, 19);
            this.totalBillCaption.TabIndex = 0;
            this.totalBillCaption.Text = "Total Tagihan";
            // 
            // methodValue
            // 
            this.methodValue.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.methodValue.Font = new System.Drawing.Font("Segoe UI", 8.5F);
            this.methodValue.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(51)))), ((int)(((byte)(65)))), ((int)(((byte)(85)))));
            this.methodValue.Location = new System.Drawing.Point(14, 155);
            this.methodValue.Name = "methodValue";
            this.methodValue.Size = new System.Drawing.Size(326, 21);
            this.methodValue.TabIndex = 5;
            this.methodValue.Text = "QRIS";
            // 
            // methodCaption
            // 
            this.methodCaption.AutoSize = true;
            this.methodCaption.Font = new System.Drawing.Font("Segoe UI", 8F, System.Drawing.FontStyle.Bold);
            this.methodCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(100)))), ((int)(((byte)(116)))), ((int)(((byte)(139)))));
            this.methodCaption.Location = new System.Drawing.Point(14, 136);
            this.methodCaption.Name = "methodCaption";
            this.methodCaption.Size = new System.Drawing.Size(150, 19);
            this.methodCaption.TabIndex = 4;
            this.methodCaption.Text = "Metode Pembayaran";
            // 
            // formatValue
            // 
            this.formatValue.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.formatValue.Font = new System.Drawing.Font("Segoe UI", 8.5F);
            this.formatValue.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(51)))), ((int)(((byte)(65)))), ((int)(((byte)(85)))));
            this.formatValue.Location = new System.Drawing.Point(14, 108);
            this.formatValue.Name = "formatValue";
            this.formatValue.Size = new System.Drawing.Size(326, 24);
            this.formatValue.TabIndex = 3;
            this.formatValue.Text = "-";
            // 
            // formatCaption
            // 
            this.formatCaption.AutoSize = true;
            this.formatCaption.Font = new System.Drawing.Font("Segoe UI", 8F, System.Drawing.FontStyle.Bold);
            this.formatCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(100)))), ((int)(((byte)(116)))), ((int)(((byte)(139)))));
            this.formatCaption.Location = new System.Drawing.Point(14, 89);
            this.formatCaption.Name = "formatCaption";
            this.formatCaption.Size = new System.Drawing.Size(57, 19);
            this.formatCaption.TabIndex = 2;
            this.formatCaption.Text = "Format";
            // 
            // itemTitleValue
            // 
            this.itemTitleValue.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.itemTitleValue.Font = new System.Drawing.Font("Segoe UI", 9F, System.Drawing.FontStyle.Bold);
            this.itemTitleValue.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.itemTitleValue.Location = new System.Drawing.Point(14, 49);
            this.itemTitleValue.Name = "itemTitleValue";
            this.itemTitleValue.Size = new System.Drawing.Size(326, 35);
            this.itemTitleValue.TabIndex = 1;
            this.itemTitleValue.Text = "-";
            // 
            // itemTitleCaption
            // 
            this.itemTitleCaption.AutoSize = true;
            this.itemTitleCaption.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.itemTitleCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(100)))), ((int)(((byte)(116)))), ((int)(((byte)(139)))));
            this.itemTitleCaption.Location = new System.Drawing.Point(14, 28);
            this.itemTitleCaption.Name = "itemTitleCaption";
            this.itemTitleCaption.Size = new System.Drawing.Size(101, 20);
            this.itemTitleCaption.TabIndex = 0;
            this.itemTitleCaption.Text = "Judul E-Book";
            // 
            // updateGroupBox
            // 
            this.updateGroupBox.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.updateGroupBox.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(255)))), ((int)(((byte)(253)))), ((int)(((byte)(245)))));
            this.updateGroupBox.Controls.Add(this.cashierNoteBox);
            this.updateGroupBox.Controls.Add(this.noteCaption);
            this.updateGroupBox.Controls.Add(this.orderStatusCombo);
            this.updateGroupBox.Controls.Add(this.currentStatusCaption);
            this.updateGroupBox.Font = new System.Drawing.Font("Georgia", 8.25F, System.Drawing.FontStyle.Bold);
            this.updateGroupBox.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(146)))), ((int)(((byte)(64)))), ((int)(((byte)(14)))));
            this.updateGroupBox.Location = new System.Drawing.Point(0, 216);
            this.updateGroupBox.Name = "updateGroupBox";
            this.updateGroupBox.Padding = new System.Windows.Forms.Padding(10);
            this.updateGroupBox.Size = new System.Drawing.Size(366, 205);
            this.updateGroupBox.TabIndex = 1;
            this.updateGroupBox.TabStop = false;
            this.updateGroupBox.Text = "Perbarui Status Pesanan";
            // 
            // cashierNoteBox
            // 
            this.cashierNoteBox.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.cashierNoteBox.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.cashierNoteBox.Font = new System.Drawing.Font("Segoe UI", 8.5F);
            this.cashierNoteBox.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(100)))), ((int)(((byte)(116)))), ((int)(((byte)(139)))));
            this.cashierNoteBox.Location = new System.Drawing.Point(14, 111);
            this.cashierNoteBox.Multiline = true;
            this.cashierNoteBox.Name = "cashierNoteBox";
            this.cashierNoteBox.Size = new System.Drawing.Size(326, 75);
            this.cashierNoteBox.TabIndex = 3;
            this.cashierNoteBox.Text = "Tulis catatan jika ada pengembalian atau manual check...";
            // 
            // noteCaption
            // 
            this.noteCaption.AutoSize = true;
            this.noteCaption.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.noteCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(120)))), ((int)(((byte)(53)))), ((int)(((byte)(15)))));
            this.noteCaption.Location = new System.Drawing.Point(14, 89);
            this.noteCaption.Name = "noteCaption";
            this.noteCaption.Size = new System.Drawing.Size(102, 20);
            this.noteCaption.TabIndex = 2;
            this.noteCaption.Text = "Catatan Kasir";
            // 
            // orderStatusCombo
            // 
            this.orderStatusCombo.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.orderStatusCombo.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList;
            this.orderStatusCombo.Font = new System.Drawing.Font("Segoe UI", 9F);
            this.orderStatusCombo.FormattingEnabled = true;
            this.orderStatusCombo.Items.AddRange(new object[] {
            "Pending - Menunggu",
            "Success - Berhasil",
            "Canceled - Dibatalkan"});
            this.orderStatusCombo.Location = new System.Drawing.Point(14, 50);
            this.orderStatusCombo.Name = "orderStatusCombo";
            this.orderStatusCombo.Size = new System.Drawing.Size(326, 28);
            this.orderStatusCombo.TabIndex = 1;
            // 
            // currentStatusCaption
            // 
            this.currentStatusCaption.AutoSize = true;
            this.currentStatusCaption.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.currentStatusCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(120)))), ((int)(((byte)(53)))), ((int)(((byte)(15)))));
            this.currentStatusCaption.Location = new System.Drawing.Point(14, 28);
            this.currentStatusCaption.Name = "currentStatusCaption";
            this.currentStatusCaption.Size = new System.Drawing.Size(115, 20);
            this.currentStatusCaption.TabIndex = 0;
            this.currentStatusCaption.Text = "Status Pesanan";
            // 
            // DetailPesananStatus
            // 
            this.AutoScroll = true;
            this.BackColor = System.Drawing.Color.White;
            this.Controls.Add(this.updateGroupBox);
            this.Controls.Add(this.detailGroupBox);
            this.Name = "DetailPesananStatus";
            this.Size = new System.Drawing.Size(382, 540);
            this.detailGroupBox.ResumeLayout(false);
            this.detailGroupBox.PerformLayout();
            this.totalBillBox.ResumeLayout(false);
            this.totalBillBox.PerformLayout();
            this.updateGroupBox.ResumeLayout(false);
            this.updateGroupBox.PerformLayout();
            this.ResumeLayout(false);

        }
    }
}
