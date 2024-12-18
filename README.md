# Job Portal Website

A **Job Portal Website** is a comprehensive online platform that connects job seekers with employers across various industries. 

🔴 Add Project Video

## Features
- **Job Seeker Profile**: Candidates can create profiles, upload resumes, and search for job openings based on keywords, location, industry, or job type.
- **Employer Dashboard**: Employers can post job listings, filter applicants, and manage recruitment processes efficiently.
- **Advanced Job Search**: Users can filter job listings by multiple criteria such as location, industry, and role.
- **Job Alerts**: Candidates receive notifications for new jobs that match their preferences.
- **Personalized Recommendations**: Based on the user's profile and search history, tailored job recommendations are provided.
- **Company Profiles**: Employers can create company profiles to showcase their workplace culture and job offerings.

The website aims to streamline the hiring process, making it easier for job seekers to find their ideal roles and for companies to identify top talent.

-----------------------------------------------------------------------------------------------------------------------------------
 
Here's a guide to set up the PHP native system for the Job Portal Website:

### Prerequisites
1. **Install XAMPP**: Download and install [XAMPP](https://www.apachefriends.org/index.html), which includes Apache and MySQL.
2. **Install Composer**: Download and install [Composer](https://getcomposer.org/download/) to manage PHP dependencies.

### Setup Steps

1. **Clone the Repository**
   - Open a terminal and navigate to your `htdocs` directory in XAMPP (usually located in `C:\xampp\htdocs` on Windows).
   - Clone the repository:
     ```bash
     git clone https://github.com/ITE183-2024-2025/JOB-PORTAL-WEBSITE.git
     ```

2. **Configure Virtual Host**
   - Open the Apache configuration file for virtual hosts, usually found in `C:\xampp\apache\conf\extra\httpd-vhosts.conf`.
   - Add the following configuration:
     ```apache
     <VirtualHost *:80>
         ServerAdmin webmaster@localhost
         DocumentRoot "C:/xampp/htdocs/JOB-PORTAL-WEBSITE"
         ServerName job-portal.local
         <Directory "C:/xampp/htdocs/JOB-PORTAL-WEBSITE">
             Options Indexes FollowSymLinks
             AllowOverride All
             Require all granted
         </Directory>
     </VirtualHost>
     ```

3. **Update Hosts File**
   - Open your hosts file (usually at `C:\Windows\System32\drivers\etc\hosts` on Windows).
   - Add this entry to point `job-portal.local` to localhost:
     ```
     127.0.0.1 job-portal.local
     ```

4. **Install Dependencies**
   - Navigate to the project directory:
     ```bash
     cd C:/xampp/htdocs/JOB-PORTAL-WEBSITE
     ```
   - Install PHP dependencies using Composer:
     ```bash
     composer install
     ```

Here’s the updated setup instruction for configuring the environment:

---

5. **Configure Environment and Database**
   - In the project directory, duplicate the `.env.example` file and rename it to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Open the `.env` file in a text editor and input your local database credentials:
     ```plaintext
     DB_HOST=127.0.0.1
     DB_NAME=your_database_name
     DB_USER=your_database_username
     DB_PASSWORD=your_database_password
     ```
   - Save the file after entering your database details.

--- 

This ensures you’re setting up your local environment configuration correctly with the cloned `.env` file.

6. **Run the Application**
   - In your browser, go to [http://job-portal.local](http://job-portal.local) to access the application.

### Additional Steps
- **Permissions**: Ensure appropriate read/write permissions on necessary folders if required.
- **Environment Configuration**: Adjust any specific environment variables needed for the application in the `.env` file if provided.

This setup should get your Job Portal Website up and running! Let me know if you need any further customization or troubleshooting.


---

TEAM MEMBERS:

1. John Mark Bolongan
2. Jade Ace Flor
3. Cyvel Gelena
4. Ivan Kenneth Jabines
5. Althea Nicole Wasawas
