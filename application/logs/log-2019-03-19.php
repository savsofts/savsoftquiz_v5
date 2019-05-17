<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-03-19 00:02:54 --> Query error: Table 'savsoftquiz_v5.0.group_invitation' doesn't exist - Invalid query: select * from group_invitation 
	join savsoft_users on savsoft_users.uid=group_invitation.invited_by 
	join social_group on social_group.sg_id=group_invitation.sg_id where group_invitation.uid='1' and invitation_status='Pending' 
ERROR - 2019-03-19 00:02:54 --> Severity: error --> Exception: Call to a member function result_array() on boolean C:\xampp\htdocs\savsoftquiz_v5\application\views\header.php 321
ERROR - 2019-03-19 00:06:14 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'appointment_request 
	join savsoft_users on savsoft_users.uid=appointment_reques' at line 1 - Invalid query: select * appointment_request 
	join savsoft_users on savsoft_users.uid=appointment_request.request_by 
	 where appointment_request.to_id='1' and appointment_status='Pending' 
ERROR - 2019-03-19 00:06:14 --> Severity: error --> Exception: Call to a member function result_array() on boolean C:\xampp\htdocs\savsoftquiz_v5\application\views\header.php 321
ERROR - 2019-03-19 00:06:48 --> Severity: Warning --> count(): Parameter must be an array or an object that implements Countable C:\xampp\htdocs\savsoftquiz_v5\application\views\header.php 328
ERROR - 2019-03-19 00:11:25 --> Severity: Warning --> Division by zero C:\xampp\htdocs\savsoftquiz_v5\application\views\dashboard.php 243
ERROR - 2019-03-19 00:12:13 --> Severity: Warning --> Division by zero C:\xampp\htdocs\savsoftquiz_v5\application\views\dashboard.php 243
ERROR - 2019-03-19 00:15:05 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'DSC
		limit 0,30' at line 6 - Invalid query: 
		select A.*, B.first_name as requested_by_name, B.skype_id as requested_by_skype
		, C.first_name as appointed_to_name, C.skype_id as appointed_to_skype
		 from appointment_request as A
		JOIN savsoft_users as B on B.uid=A.request_by
		JOIN savsoft_users as C on C.uid=A.to_id
		 order by A.appointment_timing DSC
		limit 0,30
		
ERROR - 2019-03-19 00:15:05 --> Severity: error --> Exception: Call to a member function result_array() on boolean C:\xampp\htdocs\savsoftquiz_v5\application\models\Appointment_model.php 27
ERROR - 2019-03-19 10:34:29 --> Severity: Warning --> Division by zero C:\xampp\htdocs\savsoftquiz_v5\application\views\dashboard.php 243
ERROR - 2019-03-19 10:36:07 --> Severity: Warning --> Division by zero C:\xampp\htdocs\savsoftquiz_v5\application\views\dashboard.php 243
ERROR - 2019-03-19 11:35:29 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'by order_by asc' at line 1 - Invalid query:  select * from savsoftquiz_setting orderb by order_by asc
ERROR - 2019-03-19 11:35:29 --> Severity: error --> Exception: Call to a member function result_array() on boolean C:\xampp\htdocs\savsoftquiz_v5\application\models\Setting_model.php 10
ERROR - 2019-03-19 11:35:30 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'by order_by asc' at line 1 - Invalid query:  select * from savsoftquiz_setting orderb by order_by asc
ERROR - 2019-03-19 11:35:30 --> Severity: error --> Exception: Call to a member function result_array() on boolean C:\xampp\htdocs\savsoftquiz_v5\application\models\Setting_model.php 10
ERROR - 2019-03-19 15:25:15 --> Severity: Warning --> Division by zero C:\xampp\htdocs\savsoftquiz_v5\application\views\dashboard.php 243
