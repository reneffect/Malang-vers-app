namespace dekstop
{
    partial class TransactionControl
    {
        private System.ComponentModel.IContainer components = null;
        private System.Windows.Forms.Panel headerPanel;
        private System.Windows.Forms.Label titleLabel;
        private System.Windows.Forms.Label subtitleLabel;
        private System.Windows.Forms.Panel filterPanel;
        private System.Windows.Forms.TextBox searchBox;
        private System.Windows.Forms.Label statusFilterLabel;
        private System.Windows.Forms.ComboBox statusFilterCombo;
        private System.Windows.Forms.TableLayoutPanel bodyLayout;
        private System.Windows.Forms.Panel leftCardPanel;
        private System.Windows.Forms.Panel leftCardHeader;
        private System.Windows.Forms.Label leftCardTitle;
        private System.Windows.Forms.Label countInfoLabel;
        private System.Windows.Forms.DataGridView orderGrid;
        private System.Windows.Forms.DataGridViewTextBoxColumn colNo;
        private System.Windows.Forms.DataGridViewTextBoxColumn colOrderId;
        private System.Windows.Forms.DataGridViewTextBoxColumn colTitle;
        private System.Windows.Forms.DataGridViewTextBoxColumn colDate;
        private System.Windows.Forms.DataGridViewTextBoxColumn colPrice;
        private System.Windows.Forms.DataGridViewTextBoxColumn colStatus;
        private System.Windows.Forms.DataGridViewButtonColumn colAction;
        private System.Windows.Forms.Panel leftFooterPanel;
        private System.Windows.Forms.Button firstPageBtn;
        private System.Windows.Forms.Button prevPageBtn;
        private System.Windows.Forms.Label pageInfoLabel;
        private System.Windows.Forms.Button nextPageBtn;
        private System.Windows.Forms.Button lastPageBtn;
        private System.Windows.Forms.Label totalPageValueLabel;
        private System.Windows.Forms.Panel rightCardPanel;
        private System.Windows.Forms.Panel rightHeaderPanel;
        private System.Windows.Forms.Label rightHeaderTitle;
        private System.Windows.Forms.Label selectedIdBadge;
        private System.Windows.Forms.Panel rightBodyPanel;
        private global::dekstop.DetailPesananStatus detailPesananStatusControl;
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
        private System.Windows.Forms.Panel infoNoticePanel;
        private System.Windows.Forms.Label infoNoticeLabel;
        private System.Windows.Forms.Panel inputBodyPanel;
        private System.Windows.Forms.GroupBox memberGroupBox;
        private System.Windows.Forms.Label customerNameCaption;
        private System.Windows.Forms.TextBox customerNameTextBox;
        private System.Windows.Forms.Label phoneCaption;
        private System.Windows.Forms.TextBox phoneTextBox;
        private System.Windows.Forms.GroupBox ebookInputGroupBox;
        private System.Windows.Forms.Label ebookSelectCaption;
        private System.Windows.Forms.ComboBox ebookSelectCombo;
        private System.Windows.Forms.Label unitPriceCaption;
        private System.Windows.Forms.TextBox unitPriceBox;
        private System.Windows.Forms.Button addBookBtn;
        private System.Windows.Forms.Label cartCaption;
        private System.Windows.Forms.DataGridView cartGrid;
        private System.Windows.Forms.DataGridViewTextBoxColumn colCartBook;
        private System.Windows.Forms.DataGridViewTextBoxColumn colCartSub;
        private System.Windows.Forms.DataGridViewButtonColumn colCartDel;
        private System.Windows.Forms.Label discountSelectCaption;
        private System.Windows.Forms.ComboBox discountSelectCombo;
        private System.Windows.Forms.Label finalSubtotalCaption;
        private System.Windows.Forms.Panel finalSubtotalBox;
        private System.Windows.Forms.Label finalSubtotalValue;
        private System.Windows.Forms.GroupBox paymentInputGroupBox;
        private System.Windows.Forms.Label paymentMethodCaption;
        private System.Windows.Forms.Label paymentMethodValueLabel;
        private System.Windows.Forms.Panel inputBottomSpacer;
        private System.Windows.Forms.Panel rightFooterPanel;
        private System.Windows.Forms.Button cancelButton;
        private System.Windows.Forms.Button saveButton;
        private System.Windows.Forms.Button cancelInputBtn;
        private System.Windows.Forms.Button saveTransactionBtn;

        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        private void InitializeComponent()
        {
            System.Windows.Forms.DataGridViewCellStyle dataGridViewCellStyle1 = new System.Windows.Forms.DataGridViewCellStyle();
            System.Windows.Forms.DataGridViewCellStyle dataGridViewCellStyle4 = new System.Windows.Forms.DataGridViewCellStyle();
            System.Windows.Forms.DataGridViewCellStyle dataGridViewCellStyle2 = new System.Windows.Forms.DataGridViewCellStyle();
            System.Windows.Forms.DataGridViewCellStyle dataGridViewCellStyle3 = new System.Windows.Forms.DataGridViewCellStyle();
            System.Windows.Forms.DataGridViewCellStyle dataGridViewCellStyle5 = new System.Windows.Forms.DataGridViewCellStyle();
            System.Windows.Forms.DataGridViewCellStyle dataGridViewCellStyle7 = new System.Windows.Forms.DataGridViewCellStyle();
            System.Windows.Forms.DataGridViewCellStyle dataGridViewCellStyle6 = new System.Windows.Forms.DataGridViewCellStyle();
            this.headerPanel = new System.Windows.Forms.Panel();
            this.subtitleLabel = new System.Windows.Forms.Label();
            this.titleLabel = new System.Windows.Forms.Label();
            this.filterPanel = new System.Windows.Forms.Panel();
            this.statusFilterCombo = new System.Windows.Forms.ComboBox();
            this.statusFilterLabel = new System.Windows.Forms.Label();
            this.searchBox = new System.Windows.Forms.TextBox();
            this.bodyLayout = new System.Windows.Forms.TableLayoutPanel();
            this.leftCardPanel = new System.Windows.Forms.Panel();
            this.orderGrid = new System.Windows.Forms.DataGridView();
            this.colNo = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.colOrderId = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.colTitle = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.colDate = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.colPrice = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.colStatus = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.colAction = new System.Windows.Forms.DataGridViewButtonColumn();
            this.leftFooterPanel = new System.Windows.Forms.Panel();
            this.totalPageValueLabel = new System.Windows.Forms.Label();
            this.lastPageBtn = new System.Windows.Forms.Button();
            this.nextPageBtn = new System.Windows.Forms.Button();
            this.pageInfoLabel = new System.Windows.Forms.Label();
            this.prevPageBtn = new System.Windows.Forms.Button();
            this.firstPageBtn = new System.Windows.Forms.Button();
            this.leftCardHeader = new System.Windows.Forms.Panel();
            this.countInfoLabel = new System.Windows.Forms.Label();
            this.leftCardTitle = new System.Windows.Forms.Label();
            this.rightCardPanel = new System.Windows.Forms.Panel();
            this.inputBodyPanel = new System.Windows.Forms.Panel();
            this.inputBottomSpacer = new System.Windows.Forms.Panel();
            this.paymentInputGroupBox = new System.Windows.Forms.GroupBox();
            this.paymentMethodValueLabel = new System.Windows.Forms.Label();
            this.paymentMethodCaption = new System.Windows.Forms.Label();
            this.ebookInputGroupBox = new System.Windows.Forms.GroupBox();
            this.finalSubtotalBox = new System.Windows.Forms.Panel();
            this.finalSubtotalValue = new System.Windows.Forms.Label();
            this.finalSubtotalCaption = new System.Windows.Forms.Label();
            this.discountSelectCombo = new System.Windows.Forms.ComboBox();
            this.discountSelectCaption = new System.Windows.Forms.Label();
            this.cartGrid = new System.Windows.Forms.DataGridView();
            this.colCartBook = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.colCartSub = new System.Windows.Forms.DataGridViewTextBoxColumn();
            this.colCartDel = new System.Windows.Forms.DataGridViewButtonColumn();
            this.cartCaption = new System.Windows.Forms.Label();
            this.addBookBtn = new System.Windows.Forms.Button();
            this.unitPriceBox = new System.Windows.Forms.TextBox();
            this.unitPriceCaption = new System.Windows.Forms.Label();
            this.ebookSelectCombo = new System.Windows.Forms.ComboBox();
            this.ebookSelectCaption = new System.Windows.Forms.Label();
            this.memberGroupBox = new System.Windows.Forms.GroupBox();
            this.phoneTextBox = new System.Windows.Forms.TextBox();
            this.phoneCaption = new System.Windows.Forms.Label();
            this.customerNameTextBox = new System.Windows.Forms.TextBox();
            this.customerNameCaption = new System.Windows.Forms.Label();
            this.rightBodyPanel = new System.Windows.Forms.Panel();
            this.detailPesananStatusControl = new dekstop.DetailPesananStatus();
            this.rightFooterPanel = new System.Windows.Forms.Panel();
            this.saveTransactionBtn = new System.Windows.Forms.Button();
            this.cancelInputBtn = new System.Windows.Forms.Button();
            this.saveButton = new System.Windows.Forms.Button();
            this.cancelButton = new System.Windows.Forms.Button();
            this.rightHeaderPanel = new System.Windows.Forms.Panel();
            this.selectedIdBadge = new System.Windows.Forms.Label();
            this.rightHeaderTitle = new System.Windows.Forms.Label();
            this.infoNoticePanel = new System.Windows.Forms.Panel();
            this.infoNoticeLabel = new System.Windows.Forms.Label();
            this.updateGroupBox = new System.Windows.Forms.GroupBox();
            this.cashierNoteBox = new System.Windows.Forms.TextBox();
            this.noteCaption = new System.Windows.Forms.Label();
            this.orderStatusCombo = new System.Windows.Forms.ComboBox();
            this.currentStatusCaption = new System.Windows.Forms.Label();
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
            this.headerPanel.SuspendLayout();
            this.filterPanel.SuspendLayout();
            this.bodyLayout.SuspendLayout();
            this.leftCardPanel.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.orderGrid)).BeginInit();
            this.leftFooterPanel.SuspendLayout();
            this.leftCardHeader.SuspendLayout();
            this.rightCardPanel.SuspendLayout();
            this.inputBodyPanel.SuspendLayout();
            this.paymentInputGroupBox.SuspendLayout();
            this.ebookInputGroupBox.SuspendLayout();
            this.finalSubtotalBox.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.cartGrid)).BeginInit();
            this.memberGroupBox.SuspendLayout();
            this.rightBodyPanel.SuspendLayout();
            this.rightFooterPanel.SuspendLayout();
            this.rightHeaderPanel.SuspendLayout();
            this.infoNoticePanel.SuspendLayout();
            this.updateGroupBox.SuspendLayout();
            this.detailGroupBox.SuspendLayout();
            this.totalBillBox.SuspendLayout();
            this.SuspendLayout();
            // 
            // headerPanel
            // 
            this.headerPanel.BackColor = System.Drawing.Color.White;
            this.headerPanel.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.headerPanel.Controls.Add(this.subtitleLabel);
            this.headerPanel.Controls.Add(this.titleLabel);
            this.headerPanel.Dock = System.Windows.Forms.DockStyle.Top;
            this.headerPanel.Location = new System.Drawing.Point(0, 0);
            this.headerPanel.Margin = new System.Windows.Forms.Padding(4);
            this.headerPanel.Name = "headerPanel";
            this.headerPanel.Size = new System.Drawing.Size(1349, 54);
            this.headerPanel.TabIndex = 0;
            // 
            // subtitleLabel
            // 
            this.subtitleLabel.AutoSize = true;
            this.subtitleLabel.Font = new System.Drawing.Font("Segoe UI", 8.5F);
            this.subtitleLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(100)))), ((int)(((byte)(116)))), ((int)(((byte)(139)))));
            this.subtitleLabel.Location = new System.Drawing.Point(269, 17);
            this.subtitleLabel.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.subtitleLabel.Name = "subtitleLabel";
            this.subtitleLabel.Size = new System.Drawing.Size(294, 20);
            this.subtitleLabel.TabIndex = 1;
            this.subtitleLabel.Text = "• Digital Book & Dictionary Order Processing";
            // 
            // titleLabel
            // 
            this.titleLabel.AutoSize = true;
            this.titleLabel.Font = new System.Drawing.Font("Georgia", 10F, System.Drawing.FontStyle.Bold);
            this.titleLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.titleLabel.Location = new System.Drawing.Point(16, 15);
            this.titleLabel.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.titleLabel.Name = "titleLabel";
            this.titleLabel.Size = new System.Drawing.Size(234, 20);
            this.titleLabel.TabIndex = 0;
            this.titleLabel.Text = "TRANSACTION MODULE";
            // 
            // filterPanel
            // 
            this.filterPanel.BackColor = System.Drawing.Color.White;
            this.filterPanel.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.filterPanel.Controls.Add(this.statusFilterCombo);
            this.filterPanel.Controls.Add(this.statusFilterLabel);
            this.filterPanel.Controls.Add(this.searchBox);
            this.filterPanel.Dock = System.Windows.Forms.DockStyle.Top;
            this.filterPanel.Location = new System.Drawing.Point(0, 54);
            this.filterPanel.Margin = new System.Windows.Forms.Padding(4);
            this.filterPanel.Name = "filterPanel";
            this.filterPanel.Size = new System.Drawing.Size(1349, 59);
            this.filterPanel.TabIndex = 1;
            // 
            // statusFilterCombo
            // 
            this.statusFilterCombo.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.statusFilterCombo.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList;
            this.statusFilterCombo.Font = new System.Drawing.Font("Segoe UI", 8.5F);
            this.statusFilterCombo.FormattingEnabled = true;
            this.statusFilterCombo.Items.AddRange(new object[] {
            "Semua Status",
            "Pending",
            "Success",
            "Canceled"});
            this.statusFilterCombo.Location = new System.Drawing.Point(1181, 14);
            this.statusFilterCombo.Margin = new System.Windows.Forms.Padding(4);
            this.statusFilterCombo.Name = "statusFilterCombo";
            this.statusFilterCombo.Size = new System.Drawing.Size(148, 27);
            this.statusFilterCombo.TabIndex = 2;
            this.statusFilterCombo.SelectedIndexChanged += new System.EventHandler(this.FilterChanged);
            // 
            // statusFilterLabel
            // 
            this.statusFilterLabel.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.statusFilterLabel.AutoSize = true;
            this.statusFilterLabel.Font = new System.Drawing.Font("Segoe UI", 8.5F);
            this.statusFilterLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(71)))), ((int)(((byte)(85)))), ((int)(((byte)(105)))));
            this.statusFilterLabel.Location = new System.Drawing.Point(1120, 18);
            this.statusFilterLabel.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.statusFilterLabel.Name = "statusFilterLabel";
            this.statusFilterLabel.Size = new System.Drawing.Size(52, 20);
            this.statusFilterLabel.TabIndex = 1;
            this.statusFilterLabel.Text = "Status:";
            // 
            // searchBox
            // 
            this.searchBox.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.searchBox.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.searchBox.Font = new System.Drawing.Font("Segoe UI", 9F);
            this.searchBox.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.searchBox.Location = new System.Drawing.Point(16, 14);
            this.searchBox.Margin = new System.Windows.Forms.Padding(4);
            this.searchBox.Name = "searchBox";
            this.searchBox.Size = new System.Drawing.Size(1082, 27);
            this.searchBox.TabIndex = 0;
            this.searchBox.TextChanged += new System.EventHandler(this.FilterChanged);
            // 
            // bodyLayout
            // 
            this.bodyLayout.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(244)))), ((int)(((byte)(246)))), ((int)(((byte)(250)))));
            this.bodyLayout.ColumnCount = 2;
            this.bodyLayout.ColumnStyles.Add(new System.Windows.Forms.ColumnStyle(System.Windows.Forms.SizeType.Percent, 67F));
            this.bodyLayout.ColumnStyles.Add(new System.Windows.Forms.ColumnStyle(System.Windows.Forms.SizeType.Percent, 33F));
            this.bodyLayout.Controls.Add(this.leftCardPanel, 0, 0);
            this.bodyLayout.Controls.Add(this.rightCardPanel, 1, 0);
            this.bodyLayout.Dock = System.Windows.Forms.DockStyle.Fill;
            this.bodyLayout.Location = new System.Drawing.Point(0, 113);
            this.bodyLayout.Margin = new System.Windows.Forms.Padding(4);
            this.bodyLayout.Name = "bodyLayout";
            this.bodyLayout.Padding = new System.Windows.Forms.Padding(13, 12, 13, 12);
            this.bodyLayout.RowCount = 1;
            this.bodyLayout.RowStyles.Add(new System.Windows.Forms.RowStyle(System.Windows.Forms.SizeType.Percent, 100F));
            this.bodyLayout.Size = new System.Drawing.Size(1349, 488);
            this.bodyLayout.TabIndex = 2;
            this.bodyLayout.Paint += new System.Windows.Forms.PaintEventHandler(this.bodyLayout_Paint);
            // 
            // leftCardPanel
            // 
            this.leftCardPanel.BackColor = System.Drawing.Color.White;
            this.leftCardPanel.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.leftCardPanel.Controls.Add(this.orderGrid);
            this.leftCardPanel.Controls.Add(this.leftFooterPanel);
            this.leftCardPanel.Controls.Add(this.leftCardHeader);
            this.leftCardPanel.Dock = System.Windows.Forms.DockStyle.Fill;
            this.leftCardPanel.Location = new System.Drawing.Point(13, 12);
            this.leftCardPanel.Margin = new System.Windows.Forms.Padding(0, 0, 11, 0);
            this.leftCardPanel.Name = "leftCardPanel";
            this.leftCardPanel.Size = new System.Drawing.Size(875, 464);
            this.leftCardPanel.TabIndex = 0;
            // 
            // orderGrid
            // 
            this.orderGrid.AllowUserToAddRows = false;
            this.orderGrid.AllowUserToDeleteRows = false;
            this.orderGrid.AllowUserToResizeRows = false;
            this.orderGrid.AutoSizeColumnsMode = System.Windows.Forms.DataGridViewAutoSizeColumnsMode.Fill;
            this.orderGrid.BackgroundColor = System.Drawing.Color.White;
            this.orderGrid.BorderStyle = System.Windows.Forms.BorderStyle.None;
            this.orderGrid.CellBorderStyle = System.Windows.Forms.DataGridViewCellBorderStyle.SingleHorizontal;
            this.orderGrid.ColumnHeadersBorderStyle = System.Windows.Forms.DataGridViewHeaderBorderStyle.Single;
            dataGridViewCellStyle1.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle1.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(241)))), ((int)(((byte)(245)))), ((int)(((byte)(249)))));
            dataGridViewCellStyle1.Font = new System.Drawing.Font("Georgia", 8.25F, System.Drawing.FontStyle.Bold);
            dataGridViewCellStyle1.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            dataGridViewCellStyle1.SelectionBackColor = System.Drawing.Color.FromArgb(((int)(((byte)(241)))), ((int)(((byte)(245)))), ((int)(((byte)(249)))));
            dataGridViewCellStyle1.SelectionForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            dataGridViewCellStyle1.WrapMode = System.Windows.Forms.DataGridViewTriState.True;
            this.orderGrid.ColumnHeadersDefaultCellStyle = dataGridViewCellStyle1;
            this.orderGrid.ColumnHeadersHeight = 40;
            this.orderGrid.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.DisableResizing;
            this.orderGrid.Columns.AddRange(new System.Windows.Forms.DataGridViewColumn[] {
            this.colNo,
            this.colOrderId,
            this.colTitle,
            this.colDate,
            this.colPrice,
            this.colStatus,
            this.colAction});
            dataGridViewCellStyle4.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleLeft;
            dataGridViewCellStyle4.BackColor = System.Drawing.Color.White;
            dataGridViewCellStyle4.Font = new System.Drawing.Font("Georgia", 8.25F);
            dataGridViewCellStyle4.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            dataGridViewCellStyle4.SelectionBackColor = System.Drawing.Color.FromArgb(((int)(((byte)(226)))), ((int)(((byte)(236)))), ((int)(((byte)(255)))));
            dataGridViewCellStyle4.SelectionForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            dataGridViewCellStyle4.WrapMode = System.Windows.Forms.DataGridViewTriState.True;
            this.orderGrid.DefaultCellStyle = dataGridViewCellStyle4;
            this.orderGrid.Dock = System.Windows.Forms.DockStyle.Fill;
            this.orderGrid.EnableHeadersVisualStyles = false;
            this.orderGrid.GridColor = System.Drawing.Color.FromArgb(((int)(((byte)(226)))), ((int)(((byte)(232)))), ((int)(((byte)(240)))));
            this.orderGrid.Location = new System.Drawing.Point(0, 39);
            this.orderGrid.Margin = new System.Windows.Forms.Padding(4);
            this.orderGrid.MultiSelect = false;
            this.orderGrid.Name = "orderGrid";
            this.orderGrid.ReadOnly = true;
            this.orderGrid.RowHeadersVisible = false;
            this.orderGrid.RowHeadersWidth = 51;
            this.orderGrid.RowTemplate.Height = 52;
            this.orderGrid.SelectionMode = System.Windows.Forms.DataGridViewSelectionMode.FullRowSelect;
            this.orderGrid.Size = new System.Drawing.Size(873, 379);
            this.orderGrid.TabIndex = 1;
            this.orderGrid.CellContentClick += new System.Windows.Forms.DataGridViewCellEventHandler(this.OrderGrid_CellContentClick);
            this.orderGrid.CellPainting += new System.Windows.Forms.DataGridViewCellPaintingEventHandler(this.OrderGrid_CellPainting);
            // 
            // colNo
            // 
            this.colNo.FillWeight = 32F;
            this.colNo.HeaderText = "#";
            this.colNo.MinimumWidth = 6;
            this.colNo.Name = "colNo";
            this.colNo.ReadOnly = true;
            // 
            // colOrderId
            // 
            this.colOrderId.FillWeight = 95F;
            this.colOrderId.HeaderText = "ID Pesanan ↓";
            this.colOrderId.MinimumWidth = 6;
            this.colOrderId.Name = "colOrderId";
            this.colOrderId.ReadOnly = true;
            // 
            // colTitle
            // 
            this.colTitle.FillWeight = 190F;
            this.colTitle.HeaderText = "Judul E-Book (Kamus)";
            this.colTitle.MinimumWidth = 6;
            this.colTitle.Name = "colTitle";
            this.colTitle.ReadOnly = true;
            // 
            // colDate
            // 
            this.colDate.FillWeight = 95F;
            this.colDate.HeaderText = "Tanggal & Waktu";
            this.colDate.MinimumWidth = 6;
            this.colDate.Name = "colDate";
            this.colDate.ReadOnly = true;
            // 
            // colPrice
            // 
            dataGridViewCellStyle2.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleRight;
            dataGridViewCellStyle2.Font = new System.Drawing.Font("Georgia", 8.25F, System.Drawing.FontStyle.Bold);
            this.colPrice.DefaultCellStyle = dataGridViewCellStyle2;
            this.colPrice.FillWeight = 78F;
            this.colPrice.HeaderText = "Total Harga";
            this.colPrice.MinimumWidth = 6;
            this.colPrice.Name = "colPrice";
            this.colPrice.ReadOnly = true;
            // 
            // colStatus
            // 
            dataGridViewCellStyle3.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleCenter;
            dataGridViewCellStyle3.Font = new System.Drawing.Font("Georgia", 8F, System.Drawing.FontStyle.Bold);
            this.colStatus.DefaultCellStyle = dataGridViewCellStyle3;
            this.colStatus.FillWeight = 82F;
            this.colStatus.HeaderText = "Status Pesanan";
            this.colStatus.MinimumWidth = 6;
            this.colStatus.Name = "colStatus";
            this.colStatus.ReadOnly = true;
            // 
            // colAction
            // 
            this.colAction.FillWeight = 115F;
            this.colAction.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.colAction.HeaderText = "Aksi";
            this.colAction.MinimumWidth = 110;
            this.colAction.Name = "colAction";
            this.colAction.ReadOnly = true;
            // 
            // leftFooterPanel
            // 
            this.leftFooterPanel.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(248)))), ((int)(((byte)(250)))), ((int)(((byte)(252)))));
            this.leftFooterPanel.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.leftFooterPanel.Controls.Add(this.totalPageValueLabel);
            this.leftFooterPanel.Controls.Add(this.lastPageBtn);
            this.leftFooterPanel.Controls.Add(this.nextPageBtn);
            this.leftFooterPanel.Controls.Add(this.pageInfoLabel);
            this.leftFooterPanel.Controls.Add(this.prevPageBtn);
            this.leftFooterPanel.Controls.Add(this.firstPageBtn);
            this.leftFooterPanel.Dock = System.Windows.Forms.DockStyle.Bottom;
            this.leftFooterPanel.Location = new System.Drawing.Point(0, 418);
            this.leftFooterPanel.Margin = new System.Windows.Forms.Padding(4);
            this.leftFooterPanel.Name = "leftFooterPanel";
            this.leftFooterPanel.Size = new System.Drawing.Size(873, 44);
            this.leftFooterPanel.TabIndex = 2;
            // 
            // totalPageValueLabel
            // 
            this.totalPageValueLabel.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.totalPageValueLabel.AutoSize = true;
            this.totalPageValueLabel.Font = new System.Drawing.Font("Georgia", 8.25F, System.Drawing.FontStyle.Bold);
            this.totalPageValueLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.totalPageValueLabel.Location = new System.Drawing.Point(587, 12);
            this.totalPageValueLabel.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.totalPageValueLabel.Name = "totalPageValueLabel";
            this.totalPageValueLabel.Size = new System.Drawing.Size(277, 17);
            this.totalPageValueLabel.TabIndex = 5;
            this.totalPageValueLabel.Text = "Total Pendapatan: Rp 365.000";
            // 
            // lastPageBtn
            // 
            this.lastPageBtn.BackColor = System.Drawing.Color.White;
            this.lastPageBtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.lastPageBtn.Font = new System.Drawing.Font("Segoe UI", 7.5F);
            this.lastPageBtn.Location = new System.Drawing.Point(346, 7);
            this.lastPageBtn.Margin = new System.Windows.Forms.Padding(4);
            this.lastPageBtn.Name = "lastPageBtn";
            this.lastPageBtn.Size = new System.Drawing.Size(32, 27);
            this.lastPageBtn.TabIndex = 4;
            this.lastPageBtn.Text = ">|";
            this.lastPageBtn.UseVisualStyleBackColor = false;
            // 
            // nextPageBtn
            // 
            this.nextPageBtn.BackColor = System.Drawing.Color.White;
            this.nextPageBtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.nextPageBtn.Font = new System.Drawing.Font("Segoe UI", 7.5F);
            this.nextPageBtn.Location = new System.Drawing.Point(310, 7);
            this.nextPageBtn.Margin = new System.Windows.Forms.Padding(4);
            this.nextPageBtn.Name = "nextPageBtn";
            this.nextPageBtn.Size = new System.Drawing.Size(32, 27);
            this.nextPageBtn.TabIndex = 3;
            this.nextPageBtn.Text = ">";
            this.nextPageBtn.UseVisualStyleBackColor = false;
            // 
            // pageInfoLabel
            // 
            this.pageInfoLabel.AutoSize = true;
            this.pageInfoLabel.Font = new System.Drawing.Font("Georgia", 8F);
            this.pageInfoLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(71)))), ((int)(((byte)(85)))), ((int)(((byte)(105)))));
            this.pageInfoLabel.Location = new System.Drawing.Point(83, 14);
            this.pageInfoLabel.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.pageInfoLabel.Name = "pageInfoLabel";
            this.pageInfoLabel.MaximumSize = new System.Drawing.Size(220, 0);
            this.pageInfoLabel.Size = new System.Drawing.Size(114, 17);
            this.pageInfoLabel.TabIndex = 2;
            this.pageInfoLabel.Text = "Halaman 1 dari 4";
            // 
            // prevPageBtn
            // 
            this.prevPageBtn.BackColor = System.Drawing.Color.White;
            this.prevPageBtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.prevPageBtn.Font = new System.Drawing.Font("Segoe UI", 7.5F);
            this.prevPageBtn.Location = new System.Drawing.Point(45, 7);
            this.prevPageBtn.Margin = new System.Windows.Forms.Padding(4);
            this.prevPageBtn.Name = "prevPageBtn";
            this.prevPageBtn.Size = new System.Drawing.Size(32, 27);
            this.prevPageBtn.TabIndex = 1;
            this.prevPageBtn.Text = "<";
            this.prevPageBtn.UseVisualStyleBackColor = false;
            // 
            // firstPageBtn
            // 
            this.firstPageBtn.BackColor = System.Drawing.Color.White;
            this.firstPageBtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.firstPageBtn.Font = new System.Drawing.Font("Segoe UI", 7.5F);
            this.firstPageBtn.Location = new System.Drawing.Point(11, 7);
            this.firstPageBtn.Margin = new System.Windows.Forms.Padding(4);
            this.firstPageBtn.Name = "firstPageBtn";
            this.firstPageBtn.Size = new System.Drawing.Size(32, 27);
            this.firstPageBtn.TabIndex = 0;
            this.firstPageBtn.Text = "|<";
            this.firstPageBtn.UseVisualStyleBackColor = false;
            // 
            // leftCardHeader
            // 
            this.leftCardHeader.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(248)))), ((int)(((byte)(250)))), ((int)(((byte)(252)))));
            this.leftCardHeader.Controls.Add(this.countInfoLabel);
            this.leftCardHeader.Controls.Add(this.leftCardTitle);
            this.leftCardHeader.Dock = System.Windows.Forms.DockStyle.Top;
            this.leftCardHeader.Location = new System.Drawing.Point(0, 0);
            this.leftCardHeader.Margin = new System.Windows.Forms.Padding(4);
            this.leftCardHeader.Name = "leftCardHeader";
            this.leftCardHeader.Size = new System.Drawing.Size(873, 39);
            this.leftCardHeader.TabIndex = 0;
            // 
            // countInfoLabel
            // 
            this.countInfoLabel.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.countInfoLabel.AutoSize = true;
            this.countInfoLabel.Font = new System.Drawing.Font("Georgia", 8F);
            this.countInfoLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(100)))), ((int)(((byte)(116)))), ((int)(((byte)(139)))));
            this.countInfoLabel.Location = new System.Drawing.Point(598, 11);
            this.countInfoLabel.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.countInfoLabel.Name = "countInfoLabel";
            this.countInfoLabel.Size = new System.Drawing.Size(261, 17);
            this.countInfoLabel.TabIndex = 1;
            this.countInfoLabel.Text = "Menampilkan 4 dari 42 transaksi";
            // 
            // leftCardTitle
            // 
            this.leftCardTitle.AutoSize = true;
            this.leftCardTitle.Font = new System.Drawing.Font("Georgia", 9F, System.Drawing.FontStyle.Bold);
            this.leftCardTitle.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.leftCardTitle.Location = new System.Drawing.Point(13, 10);
            this.leftCardTitle.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.leftCardTitle.Name = "leftCardTitle";
            this.leftCardTitle.Size = new System.Drawing.Size(180, 18);
            this.leftCardTitle.TabIndex = 0;
            this.leftCardTitle.Text = "Daftar Pesanan Masuk";
            // 
            // rightCardPanel
            // 
            this.rightCardPanel.BackColor = System.Drawing.Color.White;
            this.rightCardPanel.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.rightCardPanel.Controls.Add(this.inputBodyPanel);
            this.rightCardPanel.Controls.Add(this.rightBodyPanel);
            this.rightCardPanel.Controls.Add(this.rightFooterPanel);
            this.rightCardPanel.Controls.Add(this.rightHeaderPanel);
            this.rightCardPanel.Dock = System.Windows.Forms.DockStyle.Fill;
            this.rightCardPanel.Location = new System.Drawing.Point(899, 12);
            this.rightCardPanel.Margin = new System.Windows.Forms.Padding(0);
            this.rightCardPanel.Name = "rightCardPanel";
            this.rightCardPanel.Size = new System.Drawing.Size(437, 464);
            this.rightCardPanel.TabIndex = 1;
            // 
            // inputBodyPanel
            // 
            this.inputBodyPanel.AutoScroll = true;
            this.inputBodyPanel.BackColor = System.Drawing.Color.White;
            this.inputBodyPanel.Controls.Add(this.inputBottomSpacer);
            this.inputBodyPanel.Controls.Add(this.paymentInputGroupBox);
            this.inputBodyPanel.Controls.Add(this.ebookInputGroupBox);
            this.inputBodyPanel.Controls.Add(this.memberGroupBox);
            this.inputBodyPanel.Dock = System.Windows.Forms.DockStyle.Fill;
            this.inputBodyPanel.Location = new System.Drawing.Point(0, 44);
            this.inputBodyPanel.Margin = new System.Windows.Forms.Padding(4);
            this.inputBodyPanel.Name = "inputBodyPanel";
            this.inputBodyPanel.Padding = new System.Windows.Forms.Padding(16, 12, 16, 12);
            this.inputBodyPanel.Size = new System.Drawing.Size(435, 359);
            this.inputBodyPanel.TabIndex = 3;
            // 
            // inputBottomSpacer
            // 
            this.inputBottomSpacer.Location = new System.Drawing.Point(16, 636);
            this.inputBottomSpacer.Name = "inputBottomSpacer";
            this.inputBottomSpacer.Size = new System.Drawing.Size(382, 14);
            this.inputBottomSpacer.TabIndex = 3;
            // 
            // paymentInputGroupBox
            // 
            this.paymentInputGroupBox.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.paymentInputGroupBox.BackColor = System.Drawing.Color.White;
            this.paymentInputGroupBox.Controls.Add(this.paymentMethodValueLabel);
            this.paymentInputGroupBox.Controls.Add(this.paymentMethodCaption);
            this.paymentInputGroupBox.Font = new System.Drawing.Font("Georgia", 8.25F, System.Drawing.FontStyle.Bold);
            this.paymentInputGroupBox.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.paymentInputGroupBox.Location = new System.Drawing.Point(16, 548);
            this.paymentInputGroupBox.Name = "paymentInputGroupBox";
            this.paymentInputGroupBox.Size = new System.Drawing.Size(382, 82);
            this.paymentInputGroupBox.TabIndex = 2;
            this.paymentInputGroupBox.TabStop = false;
            this.paymentInputGroupBox.Text = "3. Pembayaran";
            // 
            // paymentMethodValueLabel
            // 
            this.paymentMethodValueLabel.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.paymentMethodValueLabel.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(236)))), ((int)(((byte)(253)))), ((int)(((byte)(245)))));
            this.paymentMethodValueLabel.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.paymentMethodValueLabel.Font = new System.Drawing.Font("Segoe UI", 9F, System.Drawing.FontStyle.Bold);
            this.paymentMethodValueLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(5)))), ((int)(((byte)(150)))), ((int)(((byte)(105)))));
            this.paymentMethodValueLabel.Location = new System.Drawing.Point(14, 42);
            this.paymentMethodValueLabel.Name = "paymentMethodValueLabel";
            this.paymentMethodValueLabel.Padding = new System.Windows.Forms.Padding(8, 0, 0, 0);
            this.paymentMethodValueLabel.Size = new System.Drawing.Size(352, 27);
            this.paymentMethodValueLabel.TabIndex = 1;
            this.paymentMethodValueLabel.Text = "▦  QRIS";
            this.paymentMethodValueLabel.TextAlign = System.Drawing.ContentAlignment.MiddleLeft;
            // 
            // paymentMethodCaption
            // 
            this.paymentMethodCaption.AutoSize = true;
            this.paymentMethodCaption.Font = new System.Drawing.Font("Georgia", 8F, System.Drawing.FontStyle.Bold);
            this.paymentMethodCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(51)))), ((int)(((byte)(65)))), ((int)(((byte)(85)))));
            this.paymentMethodCaption.Location = new System.Drawing.Point(14, 22);
            this.paymentMethodCaption.Name = "paymentMethodCaption";
            this.paymentMethodCaption.Size = new System.Drawing.Size(162, 17);
            this.paymentMethodCaption.TabIndex = 0;
            this.paymentMethodCaption.Text = "Metode Pembayaran:";
            // 
            // ebookInputGroupBox
            // 
            this.ebookInputGroupBox.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.ebookInputGroupBox.BackColor = System.Drawing.Color.White;
            this.ebookInputGroupBox.Controls.Add(this.finalSubtotalBox);
            this.ebookInputGroupBox.Controls.Add(this.finalSubtotalCaption);
            this.ebookInputGroupBox.Controls.Add(this.discountSelectCombo);
            this.ebookInputGroupBox.Controls.Add(this.discountSelectCaption);
            this.ebookInputGroupBox.Controls.Add(this.cartGrid);
            this.ebookInputGroupBox.Controls.Add(this.cartCaption);
            this.ebookInputGroupBox.Controls.Add(this.addBookBtn);
            this.ebookInputGroupBox.Controls.Add(this.unitPriceBox);
            this.ebookInputGroupBox.Controls.Add(this.unitPriceCaption);
            this.ebookInputGroupBox.Controls.Add(this.ebookSelectCombo);
            this.ebookInputGroupBox.Controls.Add(this.ebookSelectCaption);
            this.ebookInputGroupBox.Font = new System.Drawing.Font("Georgia", 8.25F, System.Drawing.FontStyle.Bold);
            this.ebookInputGroupBox.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.ebookInputGroupBox.Location = new System.Drawing.Point(16, 152);
            this.ebookInputGroupBox.Name = "ebookInputGroupBox";
            this.ebookInputGroupBox.Size = new System.Drawing.Size(382, 388);
            this.ebookInputGroupBox.TabIndex = 1;
            this.ebookInputGroupBox.TabStop = false;
            this.ebookInputGroupBox.Text = "2. Rincian E-Book";
            // 
            // finalSubtotalBox
            // 
            this.finalSubtotalBox.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.finalSubtotalBox.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(224)))), ((int)(((byte)(231)))), ((int)(((byte)(255)))));
            this.finalSubtotalBox.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.finalSubtotalBox.Controls.Add(this.finalSubtotalValue);
            this.finalSubtotalBox.Location = new System.Drawing.Point(14, 344);
            this.finalSubtotalBox.Name = "finalSubtotalBox";
            this.finalSubtotalBox.Size = new System.Drawing.Size(352, 32);
            this.finalSubtotalBox.TabIndex = 14;
            // 
            // finalSubtotalValue
            // 
            this.finalSubtotalValue.Dock = System.Windows.Forms.DockStyle.Fill;
            this.finalSubtotalValue.Font = new System.Drawing.Font("Georgia", 10.5F, System.Drawing.FontStyle.Bold);
            this.finalSubtotalValue.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(29)))), ((int)(((byte)(78)))), ((int)(((byte)(216)))));
            this.finalSubtotalValue.Location = new System.Drawing.Point(0, 0);
            this.finalSubtotalValue.Name = "finalSubtotalValue";
            this.finalSubtotalValue.Padding = new System.Windows.Forms.Padding(0, 0, 10, 0);
            this.finalSubtotalValue.Size = new System.Drawing.Size(350, 30);
            this.finalSubtotalValue.TabIndex = 0;
            this.finalSubtotalValue.Text = "Rp 0";
            this.finalSubtotalValue.TextAlign = System.Drawing.ContentAlignment.MiddleRight;
            // 
            // finalSubtotalCaption
            // 
            this.finalSubtotalCaption.AutoSize = true;
            this.finalSubtotalCaption.Font = new System.Drawing.Font("Georgia", 8F, System.Drawing.FontStyle.Bold);
            this.finalSubtotalCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(37)))), ((int)(((byte)(99)))), ((int)(((byte)(235)))));
            this.finalSubtotalCaption.Location = new System.Drawing.Point(14, 325);
            this.finalSubtotalCaption.Name = "finalSubtotalCaption";
            this.finalSubtotalCaption.Size = new System.Drawing.Size(157, 17);
            this.finalSubtotalCaption.TabIndex = 13;
            this.finalSubtotalCaption.Text = "Subtotal Akhir (Rp):";
            // 
            // discountSelectCombo
            // 
            this.discountSelectCombo.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.discountSelectCombo.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList;
            this.discountSelectCombo.Font = new System.Drawing.Font("Segoe UI", 8.5F);
            this.discountSelectCombo.FormattingEnabled = true;
            this.discountSelectCombo.Items.AddRange(new object[] {
            "Rp 0 (Tanpa Diskon)"});
            this.discountSelectCombo.Location = new System.Drawing.Point(14, 292);
            this.discountSelectCombo.Name = "discountSelectCombo";
            this.discountSelectCombo.Size = new System.Drawing.Size(352, 27);
            this.discountSelectCombo.TabIndex = 12;
            // 
            // discountSelectCaption
            // 
            this.discountSelectCaption.AutoSize = true;
            this.discountSelectCaption.Font = new System.Drawing.Font("Georgia", 8F, System.Drawing.FontStyle.Bold);
            this.discountSelectCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(51)))), ((int)(((byte)(65)))), ((int)(((byte)(85)))));
            this.discountSelectCaption.Location = new System.Drawing.Point(14, 273);
            this.discountSelectCaption.Name = "discountSelectCaption";
            this.discountSelectCaption.Size = new System.Drawing.Size(148, 17);
            this.discountSelectCaption.TabIndex = 11;
            this.discountSelectCaption.Text = "Diskon / Potongan:";
            // 
            // cartGrid
            // 
            this.cartGrid.AllowUserToAddRows = false;
            this.cartGrid.AllowUserToDeleteRows = false;
            this.cartGrid.AllowUserToResizeColumns = false;
            this.cartGrid.AllowUserToResizeRows = false;
            this.cartGrid.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.cartGrid.AutoSizeColumnsMode = System.Windows.Forms.DataGridViewAutoSizeColumnsMode.Fill;
            this.cartGrid.BackgroundColor = System.Drawing.Color.FromArgb(((int)(((byte)(248)))), ((int)(((byte)(250)))), ((int)(((byte)(252)))));
            this.cartGrid.CellBorderStyle = System.Windows.Forms.DataGridViewCellBorderStyle.SingleHorizontal;
            this.cartGrid.ColumnHeadersBorderStyle = System.Windows.Forms.DataGridViewHeaderBorderStyle.Single;
            dataGridViewCellStyle5.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleLeft;
            dataGridViewCellStyle5.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(241)))), ((int)(((byte)(245)))), ((int)(((byte)(249)))));
            dataGridViewCellStyle5.Font = new System.Drawing.Font("Georgia", 8.25F, System.Drawing.FontStyle.Bold);
            dataGridViewCellStyle5.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(51)))), ((int)(((byte)(65)))), ((int)(((byte)(85)))));
            dataGridViewCellStyle5.SelectionBackColor = System.Drawing.Color.FromArgb(((int)(((byte)(241)))), ((int)(((byte)(245)))), ((int)(((byte)(249)))));
            dataGridViewCellStyle5.SelectionForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(51)))), ((int)(((byte)(65)))), ((int)(((byte)(85)))));
            this.cartGrid.ColumnHeadersDefaultCellStyle = dataGridViewCellStyle5;
            this.cartGrid.ColumnHeadersHeight = 24;
            this.cartGrid.ColumnHeadersHeightSizeMode = System.Windows.Forms.DataGridViewColumnHeadersHeightSizeMode.DisableResizing;
            this.cartGrid.Columns.AddRange(new System.Windows.Forms.DataGridViewColumn[] {
            this.colCartBook,
            this.colCartSub,
            this.colCartDel});
            dataGridViewCellStyle7.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleLeft;
            dataGridViewCellStyle7.BackColor = System.Drawing.Color.White;
            dataGridViewCellStyle7.Font = new System.Drawing.Font("Georgia", 8.25F, System.Drawing.FontStyle.Bold);
            dataGridViewCellStyle7.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            dataGridViewCellStyle7.SelectionBackColor = System.Drawing.Color.FromArgb(((int)(((byte)(238)))), ((int)(((byte)(242)))), ((int)(((byte)(255)))));
            dataGridViewCellStyle7.SelectionForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            dataGridViewCellStyle7.WrapMode = System.Windows.Forms.DataGridViewTriState.True;
            this.cartGrid.DefaultCellStyle = dataGridViewCellStyle7;
            this.cartGrid.EnableHeadersVisualStyles = false;
            this.cartGrid.GridColor = System.Drawing.Color.FromArgb(((int)(((byte)(226)))), ((int)(((byte)(232)))), ((int)(((byte)(240)))));
            this.cartGrid.Location = new System.Drawing.Point(14, 182);
            this.cartGrid.MultiSelect = false;
            this.cartGrid.Name = "cartGrid";
            this.cartGrid.ReadOnly = true;
            this.cartGrid.RowHeadersVisible = false;
            this.cartGrid.RowHeadersWidth = 51;
            this.cartGrid.RowTemplate.Height = 40;
            this.cartGrid.SelectionMode = System.Windows.Forms.DataGridViewSelectionMode.FullRowSelect;
            this.cartGrid.Size = new System.Drawing.Size(352, 84);
            this.cartGrid.TabIndex = 10;
            // 
            // colCartBook
            // 
            this.colCartBook.FillWeight = 200F;
            this.colCartBook.HeaderText = "Judul Buku";
            this.colCartBook.MinimumWidth = 6;
            this.colCartBook.Name = "colCartBook";
            this.colCartBook.ReadOnly = true;
            // 
            // colCartSub
            // 
            dataGridViewCellStyle6.Alignment = System.Windows.Forms.DataGridViewContentAlignment.MiddleRight;
            dataGridViewCellStyle6.Font = new System.Drawing.Font("Segoe UI", 7.75F, System.Drawing.FontStyle.Bold);
            this.colCartSub.DefaultCellStyle = dataGridViewCellStyle6;
            this.colCartSub.FillWeight = 70F;
            this.colCartSub.HeaderText = "Subtotal";
            this.colCartSub.MinimumWidth = 6;
            this.colCartSub.Name = "colCartSub";
            this.colCartSub.ReadOnly = true;
            // 
            // colCartDel
            // 
            this.colCartDel.FillWeight = 30F;
            this.colCartDel.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.colCartDel.HeaderText = "";
            this.colCartDel.MinimumWidth = 6;
            this.colCartDel.Name = "colCartDel";
            this.colCartDel.ReadOnly = true;
            // 
            // cartCaption
            // 
            this.cartCaption.AutoSize = true;
            this.cartCaption.Font = new System.Drawing.Font("Georgia", 7.75F, System.Drawing.FontStyle.Bold);
            this.cartCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(51)))), ((int)(((byte)(65)))), ((int)(((byte)(85)))));
            this.cartCaption.Location = new System.Drawing.Point(14, 163);
            this.cartCaption.Name = "cartCaption";
            this.cartCaption.Size = new System.Drawing.Size(214, 16);
            this.cartCaption.TabIndex = 9;
            this.cartCaption.Text = "Daftar Buku Dipilih (0 item):";
            // 
            // addBookBtn
            // 
            this.addBookBtn.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.addBookBtn.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(238)))), ((int)(((byte)(242)))), ((int)(((byte)(255)))));
            this.addBookBtn.Cursor = System.Windows.Forms.Cursors.Hand;
            this.addBookBtn.FlatAppearance.BorderColor = System.Drawing.Color.FromArgb(((int)(((byte)(147)))), ((int)(((byte)(197)))), ((int)(((byte)(253)))));
            this.addBookBtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.addBookBtn.Font = new System.Drawing.Font("Segoe UI", 8F, System.Drawing.FontStyle.Bold);
            this.addBookBtn.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(29)))), ((int)(((byte)(78)))), ((int)(((byte)(216)))));
            this.addBookBtn.Location = new System.Drawing.Point(14, 130);
            this.addBookBtn.Name = "addBookBtn";
            this.addBookBtn.Size = new System.Drawing.Size(352, 27);
            this.addBookBtn.TabIndex = 8;
            this.addBookBtn.Text = "+ Tambah Buku ke Daftar Transaksi";
            this.addBookBtn.UseVisualStyleBackColor = false;
            // 
            // unitPriceBox
            // 
            this.unitPriceBox.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.unitPriceBox.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(224)))), ((int)(((byte)(231)))), ((int)(((byte)(255)))));
            this.unitPriceBox.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.unitPriceBox.Font = new System.Drawing.Font("Georgia", 8.5F, System.Drawing.FontStyle.Bold);
            this.unitPriceBox.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.unitPriceBox.Location = new System.Drawing.Point(14, 96);
            this.unitPriceBox.Name = "unitPriceBox";
            this.unitPriceBox.ReadOnly = true;
            this.unitPriceBox.Size = new System.Drawing.Size(352, 24);
            this.unitPriceBox.TabIndex = 7;
            this.unitPriceBox.Text = "Rp 0";
            this.unitPriceBox.TextAlign = System.Windows.Forms.HorizontalAlignment.Right;
            // 
            // unitPriceCaption
            // 
            this.unitPriceCaption.AutoSize = true;
            this.unitPriceCaption.Font = new System.Drawing.Font("Georgia", 8F, System.Drawing.FontStyle.Bold);
            this.unitPriceCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(51)))), ((int)(((byte)(65)))), ((int)(((byte)(85)))));
            this.unitPriceCaption.Location = new System.Drawing.Point(14, 76);
            this.unitPriceCaption.Name = "unitPriceCaption";
            this.unitPriceCaption.Size = new System.Drawing.Size(148, 17);
            this.unitPriceCaption.TabIndex = 6;
            this.unitPriceCaption.Text = "Harga E-Book (Rp):";
            // 
            // ebookSelectCombo
            // 
            this.ebookSelectCombo.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.ebookSelectCombo.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList;
            this.ebookSelectCombo.Font = new System.Drawing.Font("Segoe UI", 8.5F);
            this.ebookSelectCombo.FormattingEnabled = true;
            this.ebookSelectCombo.Location = new System.Drawing.Point(14, 42);
            this.ebookSelectCombo.Name = "ebookSelectCombo";
            this.ebookSelectCombo.Size = new System.Drawing.Size(352, 27);
            this.ebookSelectCombo.TabIndex = 1;
            // 
            // ebookSelectCaption
            // 
            this.ebookSelectCaption.AutoSize = true;
            this.ebookSelectCaption.Font = new System.Drawing.Font("Georgia", 8F, System.Drawing.FontStyle.Bold);
            this.ebookSelectCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(51)))), ((int)(((byte)(65)))), ((int)(((byte)(85)))));
            this.ebookSelectCaption.Location = new System.Drawing.Point(14, 22);
            this.ebookSelectCaption.Name = "ebookSelectCaption";
            this.ebookSelectCaption.Size = new System.Drawing.Size(160, 17);
            this.ebookSelectCaption.TabIndex = 0;
            this.ebookSelectCaption.Text = "Pilih Produk E-Book:";
            // 
            // memberGroupBox
            // 
            this.memberGroupBox.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.memberGroupBox.BackColor = System.Drawing.Color.White;
            this.memberGroupBox.Controls.Add(this.phoneTextBox);
            this.memberGroupBox.Controls.Add(this.phoneCaption);
            this.memberGroupBox.Controls.Add(this.customerNameTextBox);
            this.memberGroupBox.Controls.Add(this.customerNameCaption);
            this.memberGroupBox.Font = new System.Drawing.Font("Georgia", 8.25F, System.Drawing.FontStyle.Bold);
            this.memberGroupBox.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.memberGroupBox.Location = new System.Drawing.Point(16, 10);
            this.memberGroupBox.Name = "memberGroupBox";
            this.memberGroupBox.Size = new System.Drawing.Size(382, 134);
            this.memberGroupBox.TabIndex = 0;
            this.memberGroupBox.TabStop = false;
            this.memberGroupBox.Text = "1. Data Pelanggan";
            // 
            // phoneTextBox
            // 
            this.phoneTextBox.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.phoneTextBox.BackColor = System.Drawing.Color.White;
            this.phoneTextBox.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.phoneTextBox.Font = new System.Drawing.Font("Segoe UI", 8.5F);
            this.phoneTextBox.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.phoneTextBox.Location = new System.Drawing.Point(14, 96);
            this.phoneTextBox.MaxLength = 14;
            this.phoneTextBox.Name = "phoneTextBox";
            this.phoneTextBox.Size = new System.Drawing.Size(352, 26);
            this.phoneTextBox.TabIndex = 3;
            // 
            // phoneCaption
            // 
            this.phoneCaption.AutoSize = true;
            this.phoneCaption.Font = new System.Drawing.Font("Georgia", 8F, System.Drawing.FontStyle.Bold);
            this.phoneCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(51)))), ((int)(((byte)(65)))), ((int)(((byte)(85)))));
            this.phoneCaption.Location = new System.Drawing.Point(14, 76);
            this.phoneCaption.Name = "phoneCaption";
            this.phoneCaption.Size = new System.Drawing.Size(271, 17);
            this.phoneCaption.TabIndex = 2;
            this.phoneCaption.Text = "No. WhatsApp / HP (Maks. 14 digit):";
            // 
            // customerNameTextBox
            // 
            this.customerNameTextBox.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.customerNameTextBox.BackColor = System.Drawing.Color.White;
            this.customerNameTextBox.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.customerNameTextBox.Font = new System.Drawing.Font("Segoe UI", 8.5F);
            this.customerNameTextBox.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.customerNameTextBox.Location = new System.Drawing.Point(14, 44);
            this.customerNameTextBox.MaxLength = 50;
            this.customerNameTextBox.Name = "customerNameTextBox";
            this.customerNameTextBox.Size = new System.Drawing.Size(352, 26);
            this.customerNameTextBox.TabIndex = 1;
            // 
            // customerNameCaption
            // 
            this.customerNameCaption.AutoSize = true;
            this.customerNameCaption.Font = new System.Drawing.Font("Georgia", 8F, System.Drawing.FontStyle.Bold);
            this.customerNameCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(51)))), ((int)(((byte)(65)))), ((int)(((byte)(85)))));
            this.customerNameCaption.Location = new System.Drawing.Point(14, 24);
            this.customerNameCaption.Name = "customerNameCaption";
            this.customerNameCaption.Size = new System.Drawing.Size(134, 17);
            this.customerNameCaption.TabIndex = 0;
            this.customerNameCaption.Text = "Nama Pelanggan:";
            // 
            // rightBodyPanel
            // 
            this.rightBodyPanel.AutoScroll = true;
            this.rightBodyPanel.BackColor = System.Drawing.Color.White;
            this.rightBodyPanel.Controls.Add(this.detailPesananStatusControl);
            this.rightBodyPanel.Dock = System.Windows.Forms.DockStyle.Fill;
            this.rightBodyPanel.Location = new System.Drawing.Point(0, 44);
            this.rightBodyPanel.Margin = new System.Windows.Forms.Padding(4);
            this.rightBodyPanel.Name = "rightBodyPanel";
            this.rightBodyPanel.Padding = new System.Windows.Forms.Padding(16, 15, 16, 15);
            this.rightBodyPanel.Size = new System.Drawing.Size(435, 359);
            this.rightBodyPanel.TabIndex = 1;
            this.rightBodyPanel.Visible = false;
            // 
            // detailPesananStatusControl
            // 
            this.detailPesananStatusControl.AutoScroll = true;
            this.detailPesananStatusControl.BackColor = System.Drawing.Color.White;
            this.detailPesananStatusControl.Dock = System.Windows.Forms.DockStyle.Fill;
            this.detailPesananStatusControl.Location = new System.Drawing.Point(16, 15);
            this.detailPesananStatusControl.Name = "detailPesananStatusControl";
            this.detailPesananStatusControl.Size = new System.Drawing.Size(403, 329);
            this.detailPesananStatusControl.TabIndex = 3;
            // 
            // rightFooterPanel
            // 
            this.rightFooterPanel.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(248)))), ((int)(((byte)(250)))), ((int)(((byte)(252)))));
            this.rightFooterPanel.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.rightFooterPanel.Controls.Add(this.saveTransactionBtn);
            this.rightFooterPanel.Controls.Add(this.cancelInputBtn);
            this.rightFooterPanel.Controls.Add(this.saveButton);
            this.rightFooterPanel.Controls.Add(this.cancelButton);
            this.rightFooterPanel.Dock = System.Windows.Forms.DockStyle.Bottom;
            this.rightFooterPanel.Location = new System.Drawing.Point(0, 403);
            this.rightFooterPanel.Margin = new System.Windows.Forms.Padding(4);
            this.rightFooterPanel.Name = "rightFooterPanel";
            this.rightFooterPanel.Size = new System.Drawing.Size(435, 59);
            this.rightFooterPanel.TabIndex = 2;
            // 
            // saveTransactionBtn
            // 
            this.saveTransactionBtn.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.saveTransactionBtn.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(29)))), ((int)(((byte)(78)))), ((int)(((byte)(216)))));
            this.saveTransactionBtn.Cursor = System.Windows.Forms.Cursors.Hand;
            this.saveTransactionBtn.FlatAppearance.BorderSize = 0;
            this.saveTransactionBtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.saveTransactionBtn.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.saveTransactionBtn.ForeColor = System.Drawing.Color.White;
            this.saveTransactionBtn.Location = new System.Drawing.Point(254, 10);
            this.saveTransactionBtn.Margin = new System.Windows.Forms.Padding(4);
            this.saveTransactionBtn.Name = "saveTransactionBtn";
            this.saveTransactionBtn.Size = new System.Drawing.Size(165, 39);
            this.saveTransactionBtn.TabIndex = 3;
            this.saveTransactionBtn.Text = "Simpan Transaksi";
            this.saveTransactionBtn.UseVisualStyleBackColor = false;
            this.saveTransactionBtn.Click += new System.EventHandler(this.SaveTransactionBtn_Click);
            // 
            // cancelInputBtn
            // 
            this.cancelInputBtn.BackColor = System.Drawing.Color.White;
            this.cancelInputBtn.Cursor = System.Windows.Forms.Cursors.Hand;
            this.cancelInputBtn.FlatAppearance.BorderColor = System.Drawing.Color.FromArgb(((int)(((byte)(203)))), ((int)(((byte)(213)))), ((int)(((byte)(225)))));
            this.cancelInputBtn.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.cancelInputBtn.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.cancelInputBtn.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(51)))), ((int)(((byte)(65)))), ((int)(((byte)(85)))));
            this.cancelInputBtn.Location = new System.Drawing.Point(16, 10);
            this.cancelInputBtn.Margin = new System.Windows.Forms.Padding(4);
            this.cancelInputBtn.Name = "cancelInputBtn";
            this.cancelInputBtn.Size = new System.Drawing.Size(77, 39);
            this.cancelInputBtn.TabIndex = 2;
            this.cancelInputBtn.Text = "Batal";
            this.cancelInputBtn.UseVisualStyleBackColor = false;
            this.cancelInputBtn.Click += new System.EventHandler(this.CancelInputBtn_Click);
            // 
            // saveButton
            // 
            this.saveButton.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.saveButton.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(37)))), ((int)(((byte)(99)))), ((int)(((byte)(235)))));
            this.saveButton.Cursor = System.Windows.Forms.Cursors.Hand;
            this.saveButton.FlatAppearance.BorderSize = 0;
            this.saveButton.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.saveButton.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.saveButton.ForeColor = System.Drawing.Color.White;
            this.saveButton.Location = new System.Drawing.Point(230, 10);
            this.saveButton.Margin = new System.Windows.Forms.Padding(4);
            this.saveButton.Name = "saveButton";
            this.saveButton.Size = new System.Drawing.Size(189, 39);
            this.saveButton.TabIndex = 1;
            this.saveButton.Text = "💾  Simpan Perubahan";
            this.saveButton.UseVisualStyleBackColor = false;
            this.saveButton.Visible = false;
            // 
            // cancelButton
            // 
            this.cancelButton.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.cancelButton.BackColor = System.Drawing.Color.White;
            this.cancelButton.Cursor = System.Windows.Forms.Cursors.Hand;
            this.cancelButton.FlatAppearance.BorderColor = System.Drawing.Color.FromArgb(((int)(((byte)(203)))), ((int)(((byte)(213)))), ((int)(((byte)(225)))));
            this.cancelButton.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.cancelButton.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.cancelButton.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(51)))), ((int)(((byte)(65)))), ((int)(((byte)(85)))));
            this.cancelButton.Location = new System.Drawing.Point(142, 10);
            this.cancelButton.Margin = new System.Windows.Forms.Padding(4);
            this.cancelButton.Name = "cancelButton";
            this.cancelButton.Size = new System.Drawing.Size(77, 39);
            this.cancelButton.TabIndex = 0;
            this.cancelButton.Text = "Batal";
            this.cancelButton.UseVisualStyleBackColor = false;
            this.cancelButton.Visible = false;
            this.cancelButton.Click += new System.EventHandler(this.CancelButton_Click);
            // 
            // rightHeaderPanel
            // 
            this.rightHeaderPanel.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.rightHeaderPanel.Controls.Add(this.selectedIdBadge);
            this.rightHeaderPanel.Controls.Add(this.rightHeaderTitle);
            this.rightHeaderPanel.Dock = System.Windows.Forms.DockStyle.Top;
            this.rightHeaderPanel.Location = new System.Drawing.Point(0, 0);
            this.rightHeaderPanel.Margin = new System.Windows.Forms.Padding(4);
            this.rightHeaderPanel.Name = "rightHeaderPanel";
            this.rightHeaderPanel.Size = new System.Drawing.Size(435, 44);
            this.rightHeaderPanel.TabIndex = 0;
            // 
            // selectedIdBadge
            // 
            this.selectedIdBadge.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.selectedIdBadge.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(37)))), ((int)(((byte)(99)))), ((int)(((byte)(235)))));
            this.selectedIdBadge.Font = new System.Drawing.Font("Segoe UI", 7.5F, System.Drawing.FontStyle.Bold);
            this.selectedIdBadge.ForeColor = System.Drawing.Color.White;
            this.selectedIdBadge.Location = new System.Drawing.Point(309, 10);
            this.selectedIdBadge.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.selectedIdBadge.Name = "selectedIdBadge";
            this.selectedIdBadge.Size = new System.Drawing.Size(112, 25);
            this.selectedIdBadge.TabIndex = 1;
            this.selectedIdBadge.Text = "ORD-2026-0891";
            this.selectedIdBadge.TextAlign = System.Drawing.ContentAlignment.MiddleCenter;
            this.selectedIdBadge.Visible = false;
            // 
            // rightHeaderTitle
            // 
            this.rightHeaderTitle.AutoSize = true;
            this.rightHeaderTitle.Font = new System.Drawing.Font("Georgia", 9F, System.Drawing.FontStyle.Bold);
            this.rightHeaderTitle.ForeColor = System.Drawing.Color.White;
            this.rightHeaderTitle.Location = new System.Drawing.Point(16, 12);
            this.rightHeaderTitle.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.rightHeaderTitle.Name = "rightHeaderTitle";
            this.rightHeaderTitle.Size = new System.Drawing.Size(208, 18);
            this.rightHeaderTitle.TabIndex = 0;
            this.rightHeaderTitle.Text = "Form Input Pesanan Baru";
            // 
            // infoNoticePanel
            // 
            this.infoNoticePanel.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.infoNoticePanel.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(239)))), ((int)(((byte)(246)))), ((int)(((byte)(255)))));
            this.infoNoticePanel.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.infoNoticePanel.Controls.Add(this.infoNoticeLabel);
            this.infoNoticePanel.Location = new System.Drawing.Point(16, 482);
            this.infoNoticePanel.Margin = new System.Windows.Forms.Padding(4);
            this.infoNoticePanel.Name = "infoNoticePanel";
            this.infoNoticePanel.Size = new System.Drawing.Size(382, 56);
            this.infoNoticePanel.TabIndex = 2;
            // 
            // infoNoticeLabel
            // 
            this.infoNoticeLabel.Dock = System.Windows.Forms.DockStyle.Fill;
            this.infoNoticeLabel.Font = new System.Drawing.Font("Segoe UI", 8F);
            this.infoNoticeLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(64)))), ((int)(((byte)(175)))));
            this.infoNoticeLabel.Location = new System.Drawing.Point(0, 0);
            this.infoNoticeLabel.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.infoNoticeLabel.Name = "infoNoticeLabel";
            this.infoNoticeLabel.Padding = new System.Windows.Forms.Padding(11, 5, 11, 5);
            this.infoNoticeLabel.Size = new System.Drawing.Size(380, 54);
            this.infoNoticeLabel.TabIndex = 0;
            this.infoNoticeLabel.Text = "ⓘ  Mengubah status menjadi Success akan secara otomatis mengirimkan tautan unduha" +
    "n E-Book ke email pelanggan.";
            this.infoNoticeLabel.TextAlign = System.Drawing.ContentAlignment.MiddleLeft;
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
            this.updateGroupBox.Location = new System.Drawing.Point(16, 231);
            this.updateGroupBox.Margin = new System.Windows.Forms.Padding(4);
            this.updateGroupBox.Name = "updateGroupBox";
            this.updateGroupBox.Padding = new System.Windows.Forms.Padding(4);
            this.updateGroupBox.Size = new System.Drawing.Size(382, 236);
            this.updateGroupBox.TabIndex = 1;
            this.updateGroupBox.TabStop = false;
            this.updateGroupBox.Text = "Perbarui Status Pesanan";
            // 
            // cashierNoteBox
            // 
            this.cashierNoteBox.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.cashierNoteBox.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.cashierNoteBox.Font = new System.Drawing.Font("Georgia", 8.25F);
            this.cashierNoteBox.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(100)))), ((int)(((byte)(116)))), ((int)(((byte)(139)))));
            this.cashierNoteBox.Location = new System.Drawing.Point(16, 128);
            this.cashierNoteBox.Margin = new System.Windows.Forms.Padding(4);
            this.cashierNoteBox.Multiline = true;
            this.cashierNoteBox.Name = "cashierNoteBox";
            this.cashierNoteBox.Size = new System.Drawing.Size(350, 91);
            this.cashierNoteBox.TabIndex = 3;
            this.cashierNoteBox.Text = "Tulis catatan jika ada pengembalian atau manual check...";
            // 
            // noteCaption
            // 
            this.noteCaption.AutoSize = true;
            this.noteCaption.Font = new System.Drawing.Font("Georgia", 8F);
            this.noteCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(71)))), ((int)(((byte)(85)))), ((int)(((byte)(105)))));
            this.noteCaption.Location = new System.Drawing.Point(16, 103);
            this.noteCaption.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.noteCaption.Name = "noteCaption";
            this.noteCaption.Size = new System.Drawing.Size(164, 17);
            this.noteCaption.TabIndex = 2;
            this.noteCaption.Text = "Catatan Kasir (Opsional):";
            // 
            // orderStatusCombo
            // 
            this.orderStatusCombo.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.orderStatusCombo.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList;
            this.orderStatusCombo.Font = new System.Drawing.Font("Georgia", 8.5F);
            this.orderStatusCombo.FormattingEnabled = true;
            this.orderStatusCombo.Items.AddRange(new object[] {
            "Pending (Menunggu Verifikasi)",
            "Success (Lunas & Terkirim)",
            "Canceled (Dibatalkan)"});
            this.orderStatusCombo.Location = new System.Drawing.Point(16, 57);
            this.orderStatusCombo.Margin = new System.Windows.Forms.Padding(4);
            this.orderStatusCombo.Name = "orderStatusCombo";
            this.orderStatusCombo.Size = new System.Drawing.Size(349, 25);
            this.orderStatusCombo.TabIndex = 1;
            // 
            // currentStatusCaption
            // 
            this.currentStatusCaption.AutoSize = true;
            this.currentStatusCaption.Font = new System.Drawing.Font("Georgia", 8F);
            this.currentStatusCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(71)))), ((int)(((byte)(85)))), ((int)(((byte)(105)))));
            this.currentStatusCaption.Location = new System.Drawing.Point(16, 32);
            this.currentStatusCaption.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.currentStatusCaption.Name = "currentStatusCaption";
            this.currentStatusCaption.Size = new System.Drawing.Size(157, 17);
            this.currentStatusCaption.TabIndex = 0;
            this.currentStatusCaption.Text = "Status Pesanan Saat Ini:";
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
            this.detailGroupBox.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.detailGroupBox.Location = new System.Drawing.Point(16, 15);
            this.detailGroupBox.Margin = new System.Windows.Forms.Padding(4);
            this.detailGroupBox.Name = "detailGroupBox";
            this.detailGroupBox.Padding = new System.Windows.Forms.Padding(4);
            this.detailGroupBox.Size = new System.Drawing.Size(382, 204);
            this.detailGroupBox.TabIndex = 0;
            this.detailGroupBox.TabStop = false;
            this.detailGroupBox.Text = "Rincian E-Book & Pembayaran";
            // 
            // totalBillBox
            // 
            this.totalBillBox.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.totalBillBox.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(238)))), ((int)(((byte)(242)))), ((int)(((byte)(255)))));
            this.totalBillBox.Controls.Add(this.totalBillValue);
            this.totalBillBox.Controls.Add(this.totalBillCaption);
            this.totalBillBox.Location = new System.Drawing.Point(16, 145);
            this.totalBillBox.Margin = new System.Windows.Forms.Padding(4);
            this.totalBillBox.Name = "totalBillBox";
            this.totalBillBox.Size = new System.Drawing.Size(350, 42);
            this.totalBillBox.TabIndex = 6;
            // 
            // totalBillValue
            // 
            this.totalBillValue.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
            this.totalBillValue.AutoSize = true;
            this.totalBillValue.Font = new System.Drawing.Font("Georgia", 9.5F, System.Drawing.FontStyle.Bold);
            this.totalBillValue.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(37)))), ((int)(((byte)(99)))), ((int)(((byte)(235)))));
            this.totalBillValue.Location = new System.Drawing.Point(234, 11);
            this.totalBillValue.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.totalBillValue.Name = "totalBillValue";
            this.totalBillValue.Size = new System.Drawing.Size(90, 18);
            this.totalBillValue.TabIndex = 1;
            this.totalBillValue.Text = "Rp 85.000";
            // 
            // totalBillCaption
            // 
            this.totalBillCaption.AutoSize = true;
            this.totalBillCaption.Font = new System.Drawing.Font("Georgia", 8.25F, System.Drawing.FontStyle.Bold);
            this.totalBillCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(51)))), ((int)(((byte)(65)))), ((int)(((byte)(85)))));
            this.totalBillCaption.Location = new System.Drawing.Point(13, 12);
            this.totalBillCaption.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.totalBillCaption.Name = "totalBillCaption";
            this.totalBillCaption.Size = new System.Drawing.Size(116, 17);
            this.totalBillCaption.TabIndex = 0;
            this.totalBillCaption.Text = "Total Tagihan:";
            // 
            // methodValue
            // 
            this.methodValue.AutoSize = true;
            this.methodValue.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.methodValue.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.methodValue.Location = new System.Drawing.Point(224, 111);
            this.methodValue.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.methodValue.Name = "methodValue";
            this.methodValue.Size = new System.Drawing.Size(43, 20);
            this.methodValue.TabIndex = 5;
            this.methodValue.Text = "QRIS";
            // 
            // methodCaption
            // 
            this.methodCaption.AutoSize = true;
            this.methodCaption.Font = new System.Drawing.Font("Georgia", 8F);
            this.methodCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(100)))), ((int)(((byte)(116)))), ((int)(((byte)(139)))));
            this.methodCaption.Location = new System.Drawing.Point(224, 89);
            this.methodCaption.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.methodCaption.Name = "methodCaption";
            this.methodCaption.Size = new System.Drawing.Size(100, 17);
            this.methodCaption.TabIndex = 4;
            this.methodCaption.Text = "Metode Bayar:";
            // 
            // formatValue
            // 
            this.formatValue.AutoSize = true;
            this.formatValue.Font = new System.Drawing.Font("Segoe UI", 8.5F, System.Drawing.FontStyle.Bold);
            this.formatValue.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.formatValue.Location = new System.Drawing.Point(16, 111);
            this.formatValue.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.formatValue.Name = "formatValue";
            this.formatValue.Size = new System.Drawing.Size(159, 20);
            this.formatValue.TabIndex = 3;
            this.formatValue.Text = "PDF + EPUB (Bundle)";
            // 
            // formatCaption
            // 
            this.formatCaption.AutoSize = true;
            this.formatCaption.Font = new System.Drawing.Font("Georgia", 8F);
            this.formatCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(100)))), ((int)(((byte)(116)))), ((int)(((byte)(139)))));
            this.formatCaption.Location = new System.Drawing.Point(16, 89);
            this.formatCaption.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.formatCaption.Name = "formatCaption";
            this.formatCaption.Size = new System.Drawing.Size(58, 17);
            this.formatCaption.TabIndex = 2;
            this.formatCaption.Text = "Format:";
            // 
            // itemTitleValue
            // 
            this.itemTitleValue.AutoSize = true;
            this.itemTitleValue.Font = new System.Drawing.Font("Segoe UI", 9F, System.Drawing.FontStyle.Bold);
            this.itemTitleValue.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(30)))), ((int)(((byte)(41)))), ((int)(((byte)(59)))));
            this.itemTitleValue.Location = new System.Drawing.Point(16, 52);
            this.itemTitleValue.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.itemTitleValue.Name = "itemTitleValue";
            this.itemTitleValue.Size = new System.Drawing.Size(247, 20);
            this.itemTitleValue.TabIndex = 1;
            this.itemTitleValue.Text = "Kamus Bahasa Walikan Malang v2";
            // 
            // itemTitleCaption
            // 
            this.itemTitleCaption.AutoSize = true;
            this.itemTitleCaption.Font = new System.Drawing.Font("Georgia", 8F);
            this.itemTitleCaption.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(100)))), ((int)(((byte)(116)))), ((int)(((byte)(139)))));
            this.itemTitleCaption.Location = new System.Drawing.Point(16, 30);
            this.itemTitleCaption.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.itemTitleCaption.Name = "itemTitleCaption";
            this.itemTitleCaption.Size = new System.Drawing.Size(80, 17);
            this.itemTitleCaption.TabIndex = 0;
            this.itemTitleCaption.Text = "Judul Item:";
            // 
            // TransactionControl
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(8F, 16F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(244)))), ((int)(((byte)(246)))), ((int)(((byte)(250)))));
            this.Controls.Add(this.bodyLayout);
            this.Controls.Add(this.filterPanel);
            this.Controls.Add(this.headerPanel);
            this.Margin = new System.Windows.Forms.Padding(4);
            this.Name = "TransactionControl";
            this.Size = new System.Drawing.Size(1349, 601);
            this.headerPanel.ResumeLayout(false);
            this.headerPanel.PerformLayout();
            this.filterPanel.ResumeLayout(false);
            this.filterPanel.PerformLayout();
            this.bodyLayout.ResumeLayout(false);
            this.leftCardPanel.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.orderGrid)).EndInit();
            this.leftFooterPanel.ResumeLayout(false);
            this.leftFooterPanel.PerformLayout();
            this.leftCardHeader.ResumeLayout(false);
            this.leftCardHeader.PerformLayout();
            this.rightCardPanel.ResumeLayout(false);
            this.inputBodyPanel.ResumeLayout(false);
            this.paymentInputGroupBox.ResumeLayout(false);
            this.paymentInputGroupBox.PerformLayout();
            this.ebookInputGroupBox.ResumeLayout(false);
            this.ebookInputGroupBox.PerformLayout();
            this.finalSubtotalBox.ResumeLayout(false);
            ((System.ComponentModel.ISupportInitialize)(this.cartGrid)).EndInit();
            this.memberGroupBox.ResumeLayout(false);
            this.memberGroupBox.PerformLayout();
            this.rightBodyPanel.ResumeLayout(false);
            this.rightFooterPanel.ResumeLayout(false);
            this.rightHeaderPanel.ResumeLayout(false);
            this.rightHeaderPanel.PerformLayout();
            this.infoNoticePanel.ResumeLayout(false);
            this.updateGroupBox.ResumeLayout(false);
            this.updateGroupBox.PerformLayout();
            this.detailGroupBox.ResumeLayout(false);
            this.detailGroupBox.PerformLayout();
            this.totalBillBox.ResumeLayout(false);
            this.totalBillBox.PerformLayout();
            this.ResumeLayout(false);

        }

        #endregion
    }
}
