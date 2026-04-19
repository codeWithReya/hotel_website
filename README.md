# 🌆 City Skyline - Hotel Booking & Rental Website

City Skyline is a full-stack hotel booking and rental web application where users can explore and book different types of accommodations, rent cars, subscribe for updates, and share feedback.

---

## 🚀 Features

- 🏨 Book different types of accommodations:
  - Resorts
  - Villas
  - Apartments
  - Houseboats
- 🚗 Car rental system
- 📅 View booking details
- 📩 Subscription system (email updates)
- 💬 User feedback system
- 🔐 User registration with session-based login
- 📊 Dynamic data fetching using PHP & MySQL

---

## 🛠️ Tech Stack

**Frontend:**
- HTML
- CSS
- JavaScript

**Backend:**
- PHP

**Database:**
- MySQL

**Tools:**
- XAMPP
- VS Code

---

## 🗂️ Database Structure

### 1. users
- user_id
- name
- email
- password
- dob

### 2. bookings
- id
- booking_id
- name
- phone
- email
- request
- checkin
- checkout
- country
- state
- accommodation
- booking_date

### 3. goa_bookings
- id
- booking_id
- name
- phone
- email
- request
- checkin
- checkout
- state
- city
- booking_date

### 4. subscribe
- id
- full_name
- email

### 5. user_feedback
- id
- feedback
- created_at

---

## 🔑 How It Works

1. User registers on the website
2. Session is created for login
3. User can:
   - Book accommodations
   - Rent cars
   - View bookings
4. Data is stored in MySQL database
5. Bookings are fetched dynamically using PHP APIs

---

## ▶️ How to Run Locally

1. Install XAMPP
2. Start **Apache** and **MySQL**
3. Move project folder to:htdocs/
4. Import database in **phpMyAdmin**
5. Open browser:
6. https://localhost/hotel_website
---

## 📌 Future Improvements

- Login & logout system (separate authentication)
- Payment integration
- Admin dashboard
- Booking cancellation feature
- Email notifications

---

## 🙋‍♀️ Author

**Shreya Sharma**

---

## ⭐ Note

This is my first fully working full-stack project with frontend, backend, and database integration.
