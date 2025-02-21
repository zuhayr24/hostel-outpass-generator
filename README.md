# Hostel Outpass Generator

A software solution designed for **MIT students** to generate hostel outpasses seamlessly. Features will be continuously improved, and the UI/UX will be enhanced over time.

## Features
- Student login authentication
- Outpass request generation
- Warden approval/rejection system
- User-friendly interface (UI improvements ongoing)

## Tech Stack
- **Frontend:** HTML, CSS, React (UI enhancements in progress)
- **Backend:** Java, Spring Boot
- **Database:** MySQL

## Database Schema
**Database Name:** `hostel`

### Tables
#### `stu_log`
| Column  | Type    |
|---------|--------|
| reg_no  | VARCHAR (PK) |
| dob     | DATE (Password) |

#### `war_log`
| Column   | Type    |
|----------|--------|
| username | VARCHAR (PK) |
| password | VARCHAR |

## Installation
1. **Clone the Repository**
   ```sh
   git clone https://github.com/yourusername/hostel-outpass-generator.git
   cd hostel-outpass-generator
   ```
2. **Set Up MySQL Database**
   ```sql
   CREATE DATABASE hostel;
   USE hostel;
   CREATE TABLE stu_log (
       reg_no VARCHAR(50) PRIMARY KEY,
       dob DATE NOT NULL
   );
   CREATE TABLE war_log (
       username VARCHAR(50) PRIMARY KEY,
       password VARCHAR(255) NOT NULL
   );
   ```
3. **Configure `application.properties`**
   ```properties
   spring.datasource.url=jdbc:mysql://localhost:3306/hostel
   spring.datasource.username=root
   spring.datasource.password=yourpassword
   spring.jpa.hibernate.ddl-auto=update
   ```
4. **Run the Application**
   ```sh
   mvn spring-boot:run
   ```

## API Endpoints
| Method | Endpoint        | Description |
|--------|----------------|-------------|
| POST   | `/login/student` | Student login |
| POST   | `/login/warden`  | Warden login |
| POST   | `/outpass`      | Generate new outpass |
| GET    | `/outpass/{reg_no}` | View student outpass |
| PUT    | `/outpass/approve/{id}` | Warden approves outpass |
| DELETE | `/outpass/reject/{id}` | Warden rejects outpass |
