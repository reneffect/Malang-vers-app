using System;
using System.Drawing;
using System.Windows.Forms;

namespace dekstop
{
    internal static class Ui
    {
        public static Color Navy = Color.FromArgb(24, 35, 57);
        public static Color Blue = Color.FromArgb(45, 94, 238);
        public static Color Ink = Color.FromArgb(37, 49, 68);
        public static Color Muted = Color.FromArgb(111, 123, 142);
        public static Color Line = Color.FromArgb(224, 229, 238);

        public static Panel Card()
        {
            return new Panel { BackColor = Color.White, Padding = new Padding(14), Margin = new Padding(0) };
        }

        public static Label Label(string text, float size = 9, bool bold = false, Color? color = null)
        {
            return new Label
            {
                Text = text,
                AutoSize = true,
                Font = new Font("Segoe UI", size, bold ? FontStyle.Bold : FontStyle.Regular),
                ForeColor = color ?? Ink
            };
        }

        public static Button Button(string text, bool primary = false)
        {
            var b = new Button
            {
                Text = text,
                Height = 34,
                AutoSize = true,
                Padding = new Padding(12, 0, 12, 0),
                FlatStyle = FlatStyle.Flat,
                BackColor = primary ? Blue : Color.White,
                ForeColor = primary ? Color.White : Ink,
                Font = new Font("Segoe UI", 8.5F, FontStyle.Bold),
                Cursor = Cursors.Hand
            };
            b.FlatAppearance.BorderColor = primary ? Blue : Line;
            b.FlatAppearance.BorderSize = 1;
            return b;
        }

        public static TextBox Input(string value = "")
        {
            return new TextBox
            {
                Text = value,
                BorderStyle = BorderStyle.FixedSingle,
                Font = new Font("Segoe UI", 9),
                Height = 30,
                Width = 230
            };
        }

        public static DataGridView Grid()
        {
            var g = new DataGridView
            {
                Dock = DockStyle.Fill,
                BackgroundColor = Color.White,
                BorderStyle = BorderStyle.None,
                AllowUserToAddRows = false,
                AllowUserToDeleteRows = false,
                ReadOnly = true,
                RowHeadersVisible = false,
                SelectionMode = DataGridViewSelectionMode.FullRowSelect,
                MultiSelect = false,
                AutoSizeColumnsMode = DataGridViewAutoSizeColumnsMode.Fill,
                EnableHeadersVisualStyles = false,
                GridColor = Color.FromArgb(235, 238, 243),
                Font = new Font("Segoe UI", 8.5F)
            };
            g.RowTemplate.Height = 38;
            g.ColumnHeadersDefaultCellStyle = new DataGridViewCellStyle
            {
                BackColor = Color.FromArgb(243, 246, 251),
                ForeColor = Color.FromArgb(76, 88, 108),
                Font = new Font("Segoe UI", 8, FontStyle.Bold),
                Padding = new Padding(6)
            };
            g.DefaultCellStyle = new DataGridViewCellStyle
            {
                ForeColor = Ink,
                SelectionBackColor = Color.FromArgb(226, 235, 255),
                SelectionForeColor = Ink,
                Padding = new Padding(5),
                BackColor = Color.White
            };
            g.ColumnHeadersHeight = 38;
            return g;
        }

        public static void AddText(DataGridView g, string name, string header, int width = 100)
        {
            g.Columns.Add(new DataGridViewTextBoxColumn
            {
                Name = name,
                HeaderText = header,
                FillWeight = width
            });
        }

        public static void Heading(Control parent, string title, string subtitle)
        {
            var p = new Panel { Dock = DockStyle.Top, Height = 58 };
            var t = Label(title, 14, true);
            t.Location = new Point(0, 0);
            p.Controls.Add(t);
            var s = Label(subtitle, 8.5F, false, Muted);
            s.Location = new Point(0, 29);
            p.Controls.Add(s);
            parent.Controls.Add(p);
        }

        public static void Field(FlowLayoutPanel panel, string label, Control input)
        {
            var wrap = new Panel { Width = 255, Height = 58, Margin = new Padding(0, 0, 0, 5) };
            var l = Label(label, 8, true, Muted);
            l.Location = new Point(0, 0);
            wrap.Controls.Add(l);
            input.Location = new Point(0, 21);
            input.Width = 245;
            input.Anchor = AnchorStyles.Left | AnchorStyles.Right | AnchorStyles.Top;
            wrap.Controls.Add(input);
            panel.Controls.Add(wrap);
        }

        public static Panel Metric(string title, string value, string accent)
        {
            var p = Card();
            p.Size = new Size(190, 72);
            p.Controls.Add(Label(title, 8, true, Muted));
            var v = Label(value, 17, true, Ink);
            v.Location = new Point(14, 32);
            p.Controls.Add(v);
            return p;
        }

        public static void AddStatus(DataGridViewCell cell, string status)
        {
            cell.Value = status;
            cell.Style.ForeColor = (status.Contains("Paid") || status.Contains("Verified") || status.Contains("Selesai"))
                ? Color.FromArgb(24, 139, 91)
                : (status.Contains("Pending") || status.Contains("Menunggu"))
                    ? Color.FromArgb(188, 126, 25)
                    : Color.FromArgb(198, 70, 70);
        }
    }
}
