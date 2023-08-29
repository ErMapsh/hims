create DATABASE hims;

use hims;

CREATE TABLE visit_type(
   visit_type_id INT PRIMARY KEY auto_increment,
   visit_type VARCHAR(255)
);
insert into visit_type values (1, "Out Patient") , (2, "In Patient"), (3, "Emergency"), (4, "Day Care");

CREATE TABLE states(
	state_id INT PRIMARY KEY auto_increment,
    state_name  VARCHAR(255)
);

CREATE TABLE cities(
	city_id INT PRIMARY KEY auto_increment,
    city_name  VARCHAR(255),
    state_id int,
	FOREIGN KEY (state_id) REFERENCES states(state_id)
);

-- unique constraint i jsut removed on mobile
CREATE TABLE patients (
	patient_id int PRIMARY KEY auto_increment,
    health_id VARCHAR(255) null,
    patient_name VARCHAR(255) not null,
    gender CHAR(1) not null,
    dob DATE not null,
    mobile VARCHAR(15) not null,
    occupation VARCHAR(255),
    state INT not null,
	FOREIGN KEY (state) REFERENCES states(state_id),
	city INT not null,
	FOREIGN KEY (city) REFERENCES cities(city_id),
    pincode VARCHAR(10) not null,
    visit_type INT,
    FOREIGN KEY (visit_type) REFERENCES visit_type(visit_type_id),
    created_by INT null,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE patient_doctor_relation(
	patient_doctor_relation_id int PRIMARY KEY auto_increment,
	user_map_id INT not null,
    patient_id INT not null,
	FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
    visit_type INT,
    FOREIGN KEY (visit_type) REFERENCES visit_type(visit_type_id),
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE patient_diagnostic_report(
	id int PRIMARY KEY auto_increment,
    user_map_id INT not null,
    patient_id INT not null,
	FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
	report_type varchar(200),
    report_category varchar(200),
    laboratory_test_name varchar(200), 
    report_conclusion varchar(200),
    reporting_Doctor varchar(200),
    upload_file LONGBLOB,
    upload_file_name varchar(200),
	created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE patient_op_consultation(
id int PRIMARY KEY auto_increment,
    user_map_id INT not null,
    patient_id INT not null,
	FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
    notes varchar(200),
    upload_file longtext,
    upload_file_name varchar(200),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE patient_record_discharge_summary(
    id int PRIMARY KEY auto_increment,
    user_map_id INT not null,
    patient_id INT not null,
	FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
    notes varchar(200),
    upload_file LONGBLOB,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);   


CREATE TABLE patient_record_prescription(
    id int PRIMARY KEY auto_increment,
    user_map_id INT not null,
    patient_id INT not null,
	FOREIGN KEY (patient_id) REFERENCES patients(patient_id),
    notes varchar(200),
    upload_file LONGBLOB,
    upload_file_name varchar(200),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);