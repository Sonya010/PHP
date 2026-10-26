CREATE TABLE vacancies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    company VARCHAR(255) NOT NULL,
    salary_from INT NOT NULL,
    salary_to INT NOT NULL
);