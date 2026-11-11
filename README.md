# E-Class - Web-Based Class Management Platform

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

A web application dedicated to online class management, enabling professors to manage their courses and allowing students to seamlessly access educational resources.

Developed as part of the Web Programming 2 module at the Faculty of Sciences of El Jadida (Chouaïb Doukkali University) for the 2025–2026 academic year.

## About the Project

Integrating digital tools into higher education requires a dedicated platform for resource sharing and communication. Traditional course management via email or social media leads to fragmented course materials and a lack of centralization.

This application provides a centralized web platform designed to digitize educational exchanges in a lightweight, ergonomic, and user-friendly manner, avoiding the overhead of heavy existing enterprise solutions.

## Architecture & Technical Choices

This project incorporated a complete software engineering phase to structure the architecture prior to development:

*   **Server-Side Architecture:** Built with PHP for flexibility, database interaction, form processing, and secure user session management.
*   **Relational Database (MySQL):** Designed with strict primary and foreign keys to enforce referential integrity. The database manages complex One-to-Many and Many-to-Many relationships using junction tables.
*   **UML Modeling:** Conducted initial system analysis using Astah UML to generate Use Case and Class diagrams, ensuring system consistency and architectural reliability.

## Core Features

### Professor Dashboard
*   **Class Management:** Create virtual classrooms.
*   **Administration:** Review student enrollment requests with the ability to accept or decline them centrally.
*   **Educational Resources:** Upload files (e.g., PDFs) to publish course content online for immediate access.
*   **Communication:** Publish global announcements to notify students about exams or module updates.
*   **Assignments:** Create and assign homework, specifying submission deadlines and detailed instructions.
*   **Interactions & Profile:** View and answer student inquiries. Manage user accounts, with options to remove students from a class.

### Student Dashboard
*   **Course Access:** Search and enroll in existing classes using a unique access code provided by the instructor.
*   **Resources & Assignments:** Access and download uploaded course materials and view detailed assignment requirements.
*   **Academic Tracking:** View a chronological feed of all instructor announcements to stay updated in real time.
*   **Q&A Section:** Submit direct questions to professors and track responses.
*   **Profile Management:** Option to unenroll from a class or delete the student account.

## Development Environment

*   **Backend Stack:** Native PHP and SQL queries.
*   **Frontend Stack:** HTML5 structure, CSS3 styling, and JavaScript integration.
*   **Local Server & RDBMS:** XAMPP environment running Apache and MySQL (MariaDB).
*   **Tools & Modeling:** PhpStorm IDE and Astah UML.

## Installation & Deployment

1. Install the XAMPP development environment.
2. Clone this repository into the `htdocs` directory of your XAMPP installation:
   ```bash
   git clone [https://github.com/Med-Atir/e-class-web.git](https://github.com/Med-Atir/e-class-web.git)
   Start Apache and MySQL services via the XAMPP Control Panel.

3. Import the provided relational MySQL database (.sql file) into phpMyAdmin / MySQL.

4. Access the application in your browser at http://localhost/e-class-web.

## License

This project is licensed under the MIT License - see the LICENSE file for details. You are free to use, modify, and distribute this software for academic, personal, or commercial purposes.
Third-Party Software & Stack

    PHP: Server-side scripting runtime (PHP License).

    MySQL: Relational database engine (GPLv2 / MySQL FOSS Exception).

Developed by Mohammed Atir.
