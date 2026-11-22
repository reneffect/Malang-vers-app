namespace dekstop
{
    partial class LoginForm
    {
        private System.ComponentModel.IContainer components = null;
        private System.Windows.Forms.TableLayoutPanel rootLayout;
        private System.Windows.Forms.Panel cardPanel;
        private System.Windows.Forms.Panel brandPanel;
        private System.Windows.Forms.Panel logoPanel;
        private System.Windows.Forms.Label logoLabel;
        private System.Windows.Forms.Label brandTitle;
        private System.Windows.Forms.Label brandSubtitle;
        private System.Windows.Forms.GroupBox loginGroup;
        private System.Windows.Forms.Label usernameLabel;
        private System.Windows.Forms.Label passwordLabel;
        private System.Windows.Forms.TextBox usernameBox;
        private System.Windows.Forms.TextBox passwordBox;
        private System.Windows.Forms.CheckBox showPassword;
        private System.Windows.Forms.Panel footerPanel;
        private System.Windows.Forms.Button loginButton;

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
            this.rootLayout = new System.Windows.Forms.TableLayoutPanel();
            this.cardPanel = new System.Windows.Forms.Panel();
            this.loginGroup = new System.Windows.Forms.GroupBox();
            this.showPassword = new System.Windows.Forms.CheckBox();
            this.passwordBox = new System.Windows.Forms.TextBox();
            this.usernameBox = new System.Windows.Forms.TextBox();
            this.passwordLabel = new System.Windows.Forms.Label();
            this.usernameLabel = new System.Windows.Forms.Label();
            this.footerPanel = new System.Windows.Forms.Panel();
            this.loginButton = new System.Windows.Forms.Button();
            this.brandPanel = new System.Windows.Forms.Panel();
            this.brandSubtitle = new System.Windows.Forms.Label();
            this.brandTitle = new System.Windows.Forms.Label();
            this.logoPanel = new System.Windows.Forms.Panel();
            this.logoLabel = new System.Windows.Forms.Label();
            this.rootLayout.SuspendLayout();
            this.cardPanel.SuspendLayout();
            this.loginGroup.SuspendLayout();
            this.footerPanel.SuspendLayout();
            this.brandPanel.SuspendLayout();
            this.logoPanel.SuspendLayout();
            this.SuspendLayout();
            // 
            // rootLayout
            // 
            this.rootLayout.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(24)))), ((int)(((byte)(26)))), ((int)(((byte)(31)))));
            this.rootLayout.ColumnCount = 1;
            this.rootLayout.ColumnStyles.Add(new System.Windows.Forms.ColumnStyle(System.Windows.Forms.SizeType.Percent, 100F));
            this.rootLayout.Controls.Add(this.cardPanel, 0, 0);
            this.rootLayout.Dock = System.Windows.Forms.DockStyle.Fill;
            this.rootLayout.Location = new System.Drawing.Point(0, 0);
            this.rootLayout.Margin = new System.Windows.Forms.Padding(4);
            this.rootLayout.Name = "rootLayout";
            this.rootLayout.RowCount = 1;
            this.rootLayout.RowStyles.Add(new System.Windows.Forms.RowStyle(System.Windows.Forms.SizeType.Percent, 100F));
            this.rootLayout.Size = new System.Drawing.Size(1109, 742);
            this.rootLayout.TabIndex = 0;
            // 
            // cardPanel
            // 
            this.cardPanel.Anchor = System.Windows.Forms.AnchorStyles.None;
            this.cardPanel.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(248)))), ((int)(((byte)(249)))), ((int)(((byte)(251)))));
            this.cardPanel.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.cardPanel.Controls.Add(this.loginGroup);
            this.cardPanel.Controls.Add(this.footerPanel);
            this.cardPanel.Controls.Add(this.brandPanel);
            this.cardPanel.Location = new System.Drawing.Point(241, 189);
            this.cardPanel.Margin = new System.Windows.Forms.Padding(4);
            this.cardPanel.Name = "cardPanel";
            this.cardPanel.Size = new System.Drawing.Size(626, 364);
            this.cardPanel.TabIndex = 0;
            // 
            // loginGroup
            // 
            this.loginGroup.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(248)))), ((int)(((byte)(249)))), ((int)(((byte)(251)))));
            this.loginGroup.Controls.Add(this.showPassword);
            this.loginGroup.Controls.Add(this.passwordBox);
            this.loginGroup.Controls.Add(this.usernameBox);
            this.loginGroup.Controls.Add(this.passwordLabel);
            this.loginGroup.Controls.Add(this.usernameLabel);
            this.loginGroup.Font = new System.Drawing.Font("Georgia", 8.25F, System.Drawing.FontStyle.Bold);
            this.loginGroup.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(38)))), ((int)(((byte)(47)))), ((int)(((byte)(64)))));
            this.loginGroup.Location = new System.Drawing.Point(24, 101);
            this.loginGroup.Margin = new System.Windows.Forms.Padding(4);
            this.loginGroup.Name = "loginGroup";
            this.loginGroup.Padding = new System.Windows.Forms.Padding(4);
            this.loginGroup.Size = new System.Drawing.Size(576, 177);
            this.loginGroup.TabIndex = 1;
            this.loginGroup.TabStop = false;
            this.loginGroup.Text = "LOGIN";
            // 
            // showPassword
            // 
            this.showPassword.AutoSize = true;
            this.showPassword.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(248)))), ((int)(((byte)(249)))), ((int)(((byte)(251)))));
            this.showPassword.Font = new System.Drawing.Font("Georgia", 8.25F);
            this.showPassword.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(55)))), ((int)(((byte)(65)))), ((int)(((byte)(81)))));
            this.showPassword.Location = new System.Drawing.Point(197, 133);
            this.showPassword.Margin = new System.Windows.Forms.Padding(4);
            this.showPassword.Name = "showPassword";
            this.showPassword.Size = new System.Drawing.Size(136, 21);
            this.showPassword.TabIndex = 4;
            this.showPassword.Text = "Tampilkan Sandi";
            this.showPassword.UseVisualStyleBackColor = false;
            this.showPassword.CheckedChanged += new System.EventHandler(this.ShowPassword_CheckedChanged);
            // 
            // passwordBox
            // 
            this.passwordBox.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.passwordBox.Font = new System.Drawing.Font("Georgia", 9.5F);
            this.passwordBox.Location = new System.Drawing.Point(197, 86);
            this.passwordBox.Margin = new System.Windows.Forms.Padding(4);
            this.passwordBox.Name = "passwordBox";
            this.passwordBox.Size = new System.Drawing.Size(349, 25);
            this.passwordBox.TabIndex = 3;
            this.passwordBox.UseSystemPasswordChar = true;
            // 
            // usernameBox
            // 
            this.usernameBox.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.usernameBox.Font = new System.Drawing.Font("Georgia", 9.5F);
            this.usernameBox.Location = new System.Drawing.Point(197, 37);
            this.usernameBox.Margin = new System.Windows.Forms.Padding(4);
            this.usernameBox.Name = "usernameBox";
            this.usernameBox.Size = new System.Drawing.Size(349, 25);
            this.usernameBox.TabIndex = 2;
            this.usernameBox.TextChanged += new System.EventHandler(this.usernameBox_TextChanged);
            // 
            // passwordLabel
            // 
            this.passwordLabel.Font = new System.Drawing.Font("Georgia", 8.5F);
            this.passwordLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(55)))), ((int)(((byte)(65)))), ((int)(((byte)(81)))));
            this.passwordLabel.Location = new System.Drawing.Point(32, 86);
            this.passwordLabel.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.passwordLabel.Name = "passwordLabel";
            this.passwordLabel.Size = new System.Drawing.Size(149, 30);
            this.passwordLabel.TabIndex = 1;
            this.passwordLabel.Text = "Password:";
            this.passwordLabel.TextAlign = System.Drawing.ContentAlignment.MiddleRight;
            // 
            // usernameLabel
            // 
            this.usernameLabel.Font = new System.Drawing.Font("Georgia", 8.5F);
            this.usernameLabel.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(55)))), ((int)(((byte)(65)))), ((int)(((byte)(81)))));
            this.usernameLabel.Location = new System.Drawing.Point(32, 37);
            this.usernameLabel.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.usernameLabel.Name = "usernameLabel";
            this.usernameLabel.Size = new System.Drawing.Size(149, 30);
            this.usernameLabel.TabIndex = 0;
            this.usernameLabel.Text = "Username:";
            this.usernameLabel.TextAlign = System.Drawing.ContentAlignment.MiddleRight;
            // 
            // footerPanel
            // 
            this.footerPanel.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(232)))), ((int)(((byte)(235)))), ((int)(((byte)(240)))));
            this.footerPanel.Controls.Add(this.loginButton);
            this.footerPanel.Dock = System.Windows.Forms.DockStyle.Bottom;
            this.footerPanel.Location = new System.Drawing.Point(0, 296);
            this.footerPanel.Margin = new System.Windows.Forms.Padding(4);
            this.footerPanel.Name = "footerPanel";
            this.footerPanel.Size = new System.Drawing.Size(624, 66);
            this.footerPanel.TabIndex = 2;
            // 
            // loginButton
            // 
            this.loginButton.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(54)))), ((int)(((byte)(86)))), ((int)(((byte)(255)))));
            this.loginButton.Cursor = System.Windows.Forms.Cursors.Hand;
            this.loginButton.FlatAppearance.BorderSize = 0;
            this.loginButton.FlatStyle = System.Windows.Forms.FlatStyle.Flat;
            this.loginButton.Font = new System.Drawing.Font("Georgia", 9.5F, System.Drawing.FontStyle.Bold);
            this.loginButton.ForeColor = System.Drawing.Color.White;
            this.loginButton.Location = new System.Drawing.Point(259, 14);
            this.loginButton.Margin = new System.Windows.Forms.Padding(4);
            this.loginButton.Name = "loginButton";
            this.loginButton.Size = new System.Drawing.Size(107, 39);
            this.loginButton.TabIndex = 0;
            this.loginButton.Text = "Login";
            this.loginButton.UseVisualStyleBackColor = false;
            this.loginButton.Click += new System.EventHandler(this.LoginButton_Click);
            // 
            // brandPanel
            // 
            this.brandPanel.BackColor = System.Drawing.Color.White;
            this.brandPanel.Controls.Add(this.brandSubtitle);
            this.brandPanel.Controls.Add(this.brandTitle);
            this.brandPanel.Controls.Add(this.logoPanel);
            this.brandPanel.Dock = System.Windows.Forms.DockStyle.Top;
            this.brandPanel.Location = new System.Drawing.Point(0, 0);
            this.brandPanel.Margin = new System.Windows.Forms.Padding(4);
            this.brandPanel.Name = "brandPanel";
            this.brandPanel.Size = new System.Drawing.Size(624, 84);
            this.brandPanel.TabIndex = 0;
            // 
            // brandSubtitle
            // 
            this.brandSubtitle.AutoSize = true;
            this.brandSubtitle.Font = new System.Drawing.Font("Georgia", 8.25F);
            this.brandSubtitle.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(100)))), ((int)(((byte)(110)))), ((int)(((byte)(125)))));
            this.brandSubtitle.Location = new System.Drawing.Point(93, 44);
            this.brandSubtitle.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.brandSubtitle.Name = "brandSubtitle";
            this.brandSubtitle.Size = new System.Drawing.Size(236, 17);
            this.brandSubtitle.TabIndex = 2;
            this.brandSubtitle.Text = "Terminal POS Digital E-Book Kamus";
            // 
            // brandTitle
            // 
            this.brandTitle.AutoSize = true;
            this.brandTitle.Font = new System.Drawing.Font("Georgia", 10.5F, System.Drawing.FontStyle.Bold);
            this.brandTitle.ForeColor = System.Drawing.Color.FromArgb(((int)(((byte)(32)))), ((int)(((byte)(42)))), ((int)(((byte)(61)))));
            this.brandTitle.Location = new System.Drawing.Point(93, 20);
            this.brandTitle.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.brandTitle.Name = "brandTitle";
            this.brandTitle.Size = new System.Drawing.Size(131, 21);
            this.brandTitle.TabIndex = 1;
            this.brandTitle.Text = "MalangVerse";
            // 
            // logoPanel
            // 
            this.logoPanel.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(54)))), ((int)(((byte)(86)))), ((int)(((byte)(255)))));
            this.logoPanel.Controls.Add(this.logoLabel);
            this.logoPanel.Location = new System.Drawing.Point(27, 18);
            this.logoPanel.Margin = new System.Windows.Forms.Padding(4);
            this.logoPanel.Name = "logoPanel";
            this.logoPanel.Size = new System.Drawing.Size(51, 47);
            this.logoPanel.TabIndex = 0;
            // 
            // logoLabel
            // 
            this.logoLabel.Dock = System.Windows.Forms.DockStyle.Fill;
            this.logoLabel.Font = new System.Drawing.Font("Segoe UI", 16F, System.Drawing.FontStyle.Bold);
            this.logoLabel.ForeColor = System.Drawing.Color.White;
            this.logoLabel.Location = new System.Drawing.Point(0, 0);
            this.logoLabel.Margin = new System.Windows.Forms.Padding(4, 0, 4, 0);
            this.logoLabel.Name = "logoLabel";
            this.logoLabel.Size = new System.Drawing.Size(51, 47);
            this.logoLabel.TabIndex = 0;
            this.logoLabel.Text = "▣";
            this.logoLabel.TextAlign = System.Drawing.ContentAlignment.MiddleCenter;
            // 
            // LoginForm
            // 
            this.AcceptButton = this.loginButton;
            this.AutoScaleDimensions = new System.Drawing.SizeF(8F, 16F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(24)))), ((int)(((byte)(26)))), ((int)(((byte)(31)))));
            this.ClientSize = new System.Drawing.Size(1109, 742);
            this.Controls.Add(this.rootLayout);
            this.Margin = new System.Windows.Forms.Padding(4);
            this.MinimumSize = new System.Drawing.Size(1127, 789);
            this.Name = "LoginForm";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "MalangVerse Kasir - Login";
            this.rootLayout.ResumeLayout(false);
            this.cardPanel.ResumeLayout(false);
            this.loginGroup.ResumeLayout(false);
            this.loginGroup.PerformLayout();
            this.footerPanel.ResumeLayout(false);
            this.brandPanel.ResumeLayout(false);
            this.brandPanel.PerformLayout();
            this.logoPanel.ResumeLayout(false);
            this.ResumeLayout(false);

        }

        #endregion
    }
}
