from tkinter import *
from tkinter import messagebox, simpledialog
from PIL import Image, ImageTk
import sqlite3
import os

class StudentListDialog:
    def __init__(self, parent, students, app_ref):
        self.top = Toplevel(parent)
        self.top.title("Student List")
        self.top.geometry("500x500")
        self.top.configure(bg="white")
        self.app_ref = app_ref
        self.students = students

        self.listbox = Listbox(self.top, font=("Arial", 12), width=40, height=15)
        self.listbox.pack(pady=20)
        self.populate_list()

        btn_frame = Frame(self.top, bg="white")
        btn_frame.pack(pady=10)

        Button(btn_frame, text="Edit", bg="#240333", fg="white", width=10, command=self.edit_student).pack(side=LEFT, padx=5)
        Button(btn_frame, text="Delete", bg="#2E0303", fg="white", width=10, command=self.delete_student).pack(side=LEFT, padx=5)
        Button(btn_frame, text="Back", bg="#050101", fg="white", width=10, command=self.top.destroy).pack(side=LEFT, padx=5)

    def populate_list(self):
        self.listbox.delete(0, END)
        for idx, (id_, name, sid) in enumerate(self.students):
            self.listbox.insert(END, f"{idx + 1}. {name} (ID: {sid})")

    def edit_student(self):
        selected = self.listbox.curselection()
        if selected:
            index = selected[0]
            student_id, name, sid = self.students[index]
            new_name = simpledialog.askstring("Edit Name", "Enter new name:", initialvalue=name)
            new_sid = simpledialog.askstring("Edit ID", "Enter new ID:", initialvalue=sid)
            if new_name and new_sid:
                self.app_ref.update_student(student_id, new_name.strip(), new_sid.strip())
                self.refresh_students()
            else:
                messagebox.showwarning("Input Error", "Name and ID cannot be empty.")
        else:
            messagebox.showwarning("No Selection", "Please select a student to edit.")

    def delete_student(self):
        selected = self.listbox.curselection()
        if selected:
            index = selected[0]
            student_id, _, _ = self.students[index]
            confirm = messagebox.askyesno("Confirm Delete", "Are you sure you want to delete this student?")
            if confirm:
                self.app_ref.delete_student(student_id)
                self.refresh_students()
        else:
            messagebox.showwarning("No Selection", "Please select a student to delete.")

    def refresh_students(self):
        self.app_ref.cursor.execute("SELECT id, name, student_id FROM students")
        self.students = self.app_ref.cursor.fetchall()
        self.populate_list()

class StudentApp:
    def __init__(self, root):
        self.root = root
        self.root.title("---- Students Fall In ----")
        self.root.geometry("1000x800")
        self.root.resizable(False, False)
        self.setup_database()
        self.setup_ui()

    def setup_database(self):
        try:
            self.conn = sqlite3.connect("students.db")
            self.cursor = self.conn.cursor()
            self.cursor.execute("""
                CREATE TABLE IF NOT EXISTS students (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    name TEXT NOT NULL,
                    student_id TEXT NOT NULL
                )
            """)
            self.conn.commit()
        except sqlite3.Error as e:
            messagebox.showerror("Database Error", f"Failed to connect to database: {e}")
            return

    def setup_ui(self):
        self.canvas = Canvas(self.root, width=1000, height=800, bg="#C093C8")
        self.canvas.pack(fill="both", expand=True)
        
        try:
            image_path = "shades.png"
            if os.path.exists(image_path):
                bg_image = Image.open(image_path)
                bg_image = bg_image.resize((1000, 800))
                self.bg_photo = ImageTk.PhotoImage(bg_image)
                self.canvas.create_image(0, 0, image=self.bg_photo, anchor="nw")
            else:
                self.canvas.create_rectangle(0, 0, 1000, 800, fill="#6B6B6B", outline="")
        except Exception as e:
            self.canvas.create_rectangle(0, 0, 1000, 800, fill="#545454", outline="")

        self.name_label = Label(self.canvas, text="Student Name:", bg="#C093C8", font=("Arial", 12))
        self.id_label = Label(self.canvas, text="Student ID:", bg="#C093C8", font=("Arial", 12))
        self.name_entry = Entry(self.canvas, font=("Arial", 12))
        self.id_entry = Entry(self.canvas, font=("Arial", 12))
        
        self.save_btn = Button(self.canvas, text="Save Student", bg="#8E46AF", fg="white", 
                              font=("Arial", 12), command=self.save_student)
        self.view_btn = Button(self.canvas, text="View Students", bg="#410F59", fg="white", 
                              font=("Arial", 12), command=self.view_students)
        self.db_view_btn = Button(self.canvas, text="View Database", bg="#4D0F05", fg="white", 
                                 font=("Arial", 12), command=self.show_database)

        self.canvas.create_window(500, 200, window=self.name_label)
        self.canvas.create_window(500, 230, window=self.name_entry, width=200, height=25)
        self.canvas.create_window(500, 270, window=self.id_label)
        self.canvas.create_window(500, 300, window=self.id_entry, width=200, height=25)
        self.canvas.create_window(500, 350, window=self.save_btn, width=120, height=30)
        self.canvas.create_window(500, 400, window=self.view_btn, width=120, height=30)
        self.canvas.create_window(500, 450, window=self.db_view_btn, width=120, height=30)

    def show_database(self):
        try:
            self.cursor.execute("SELECT * FROM students")
            students = self.cursor.fetchall()
            if students:
                db_window = Toplevel(self.root)
                db_window.title("Database Contents")
                db_window.geometry("600x400")
                text_widget = Text(db_window, font=("Courier", 12))
                text_widget.pack(fill="both", expand=True, padx=10, pady=10)
                text_widget.insert(END, "ID | Name           | Student ID\n")
                text_widget.insert(END, "-" * 40 + "\n")
                for student in students:
                    text_widget.insert(END, f"{student[0]:2} | {student[1]:15} | {student[2]}\n")
                text_widget.config(state=DISABLED)
            else:
                messagebox.showinfo("Database", "No students in database")
        except sqlite3.Error as e:
            messagebox.showerror("Error", f"Failed to read database: {e}")

    def save_student(self):
        name = self.name_entry.get().strip()
        sid = self.id_entry.get().strip()
        if name and sid:
            try:
                self.cursor.execute("INSERT INTO students (name, student_id) VALUES (?, ?)", (name, sid))
                self.conn.commit()
                self.name_entry.delete(0, END)
                self.id_entry.delete(0, END)
                messagebox.showinfo("Success", "Student saved successfully!")
            except sqlite3.Error as e:
                messagebox.showerror("Database Error", f"Failed to save student: {e}")
        else:
            messagebox.showwarning("Input Error", "Name and ID cannot be empty.")

    def view_students(self):
        try:
            self.cursor.execute("SELECT id, name, student_id FROM students")
            students = self.cursor.fetchall()
            if students:
                StudentListDialog(self.root, students, self)
            else:
                messagebox.showinfo("Info", "No students added yet.")
        except sqlite3.Error as e:
            messagebox.showerror("Database Error", f"Failed to load students: {e}")

    def update_student(self, student_id, new_name, new_sid):
        try:
            self.cursor.execute("UPDATE students SET name=?, student_id=? WHERE id=?", 
                              (new_name, new_sid, student_id))
            self.conn.commit()
            messagebox.showinfo("Success", "Student updated successfully!")
        except sqlite3.Error as e:
            messagebox.showerror("Database Error", f"Failed to update student: {e}")

    def delete_student(self, student_id):
        try:
            self.cursor.execute("DELETE FROM students WHERE id=?", (student_id,))
            self.conn.commit()
            messagebox.showinfo("Success", "Student deleted successfully!")
        except sqlite3.Error as e:
            messagebox.showerror("Database Error", f"Failed to delete student: {e}")

    def __del__(self):
        if hasattr(self, 'conn'):
            self.conn.close()

if __name__ == "_main_":
    root = Tk()
    app = StudentApp(root)
    root.mainloop()