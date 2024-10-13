Create database "sedp_hrmsDB";

 *************************Table structure for table `Job`***************************
CREATE TABLE tblJob (
    jobId INT AUTO_INCREMENT PRIMARY KEY, -- Primary Key (auto-incremented ID)
    title VARCHAR(255) NOT NULL,                  -- Applicant's name
    description TEXT NOT NULL,                 -- Applicant's email
    qualification VARCHAR(15) NOT NULL,                -- Applicant's contact number
    minimumSalary INT NOT NULL,                                -- Message provided by the applicant (optional)
    maximumSalary INT NOT NULL,                         -- Job ID (foreign key reference)
);
*****************************************************************************************************

***************************Table structure for table `Department`**********************************
CREATE TABLE tblDepartment (
    departmentId INT AUTO_INCREMENT PRIMARY KEY, -- PK for the table
    name VARCHAR(255) NOT NULL,                  -- Department name
    description TEXT,                             -- Description of the department

    -- Foreign keys
    branchId INT,                               -- FK to Branch table

    -- Constraints for FK
    CONSTRAINT fk_branch FOREIGN KEY (BranchId) REFERENCES tblBranch(BranchId)
        ON DELETE SET NULL ON UPDATE CASCADE
);
*****************************************************************************************************

***************************Table structure for table `Branch`**********************************
CREATE TABLE tblBranch (
    branchId INT AUTO_INCREMENT PRIMARY KEY, -- PK for the table
    name VARCHAR(255) NOT NULL,                  -- Branch name
    location TEXT,                             -- Location of the Branch
);
*****************************************************************************************************

***************************Table structure for table `JobOffer`**********************************
CREATE TABLE tblJobOffer (
    JobOfferId INT AUTO_INCREMENT PRIMARY KEY, -- PK for the table
    EmploymentType VARCHAR(255) NOT NULL,             
    datePosted  DATE NOT NULL DEFAULT CURRENT_DATE, -- Date of Posted

    -- Foreign keys
    jobId INT,                               -- FK to Job table
    departmentId INT,                            -- FK to Department table

    -- Constraints for FK
    CONSTRAINT fk_job FOREIGN KEY (jobId) REFERENCES tblJob(jobId)
        ON DELETE SET NULL ON UPDATE CASCADE
    CONSTRAINT fk_department FOREIGN KEY (departmentId) REFERENCES tbldepartment(departmentId)
        ON DELETE SET NULL ON UPDATE CASCADE
);
*****************************************************************************************************


 *************************Table structure for table `JobApplicant`***************************

CREATE TABLE tbljobapplicant (
    applicantId INT AUTO_INCREMENT PRIMARY KEY,
    uniqueId VARCHAR(255) NOT NULL UNIQUE,  -- Unique ID for each applicant
    name VARCHAR(255) NOT NULL,              -- Applicant's name (combined first, middle, last name)
    email VARCHAR(255) NOT NULL, 
    contactNumber VARCHAR(50) NOT NULL,      -- Contact number of the applicant
    appliedDate DATE NOT NULL,               -- Date when the application was submitted
    fileName VARCHAR(255),                  -- Name of the uploaded file (stored on server)
    fileSize INT,                           -- Size of the file in bytes
    fileType VARCHAR(50),                   -- MIME type of the file (e.g., application/pdf)
    status VARCHAR(50) DEFAULT 'Pending',    -- Status of the application (default: 'Pending')
    jobOfferId INT,                 -- Foreign key referencing job offer ID

    -- Constraints for FK
    CONSTRAINT fk_job_offer FOREIGN KEY (JobOfferId) REFERENCES tblJobOffer(JobOfferId)
        ON DELETE SET NULL ON UPDATE CASCADE
);


SELECT 
    j.title,
    j.description AS  Responsibility,
    j.qualification,
    j.minimumSalary,
    j.maximumSalary,
    jo.employmentType,
    jo.datePosted,
    b.location AS branchLocation
FROM 
    tbljobOffer jo
JOIN 
    tbljob j ON jo.jobId = j.jobId
JOIN 
    tbldepartment d ON jo.departmentId = d.departmentId
JOIN 
    tblbranch b ON d.branchId = b.branchId;
