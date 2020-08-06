## MINI-CRM

# How to use this app:-
- Clone the repository with git clone
- Copy the .env.example file content into .env(create new or rename .env.example).
- Run composer install
- Create a database for the same & run migrations.
- Run the UserSeeder to generate a login account for testing the application <h3>(php artisan db:seed -class="UserSeeder")</h3>.
- Also to generate fake company or employee data use EmployeeSeeder or CompanySeeder.
- Enjoy the application.

# Functionality:-

- [✅] Basic testing with phpunit.
- [✅] Use Laravel make:auth as default Bootstrap-based design theme, but remove ability to register.
- [✅] Companies DB table consists of these fields: Name (required), email, logo (minimum 100×100), website.
- [✅] Employees DB table consists of these fields: First name (required), last name (required), Company (foreign key to Companies), email, phone.
- [✅] Use database migrations to create those schemas above
- [✅] Use database seeds to create first user with email admin@admin.com and password “password”
- [✅] Basic Laravel Auth: ability to log in as administrator
- [✅] Use basic Laravel resource controllers with default methods – index, create, store etc.
- [✅] CRUD functionality (Create / Read / Update / Delete) for two menu items: Companies and Employees.
- [✅] Store companies logos in storage/app/public folder and make them accessible from public.
- [✅] Use Laravel’s validation function, using Request classes.
- [✅] Use Laravel’s pagination for showing Companies/Employees list, 10 entries per page.
- [✅] Use Datatables.net library to show table – with server-side rendering.
- [✅] Email notification: send email whenever new company is entered (use Mailgun or Mailtrap).
- [X] Use Core UI (free version)
- [✅] Dashboard should list
- [✅] a) Employees created yesterday
- [✅] b) Companies created yesterday
- [✅] c) Total Employees
- [✅] d) Total Companies
- [✅] Line Graph displaying employees and companies created over time (Day, Month & Year)
- [✅] Admin should be able to edit their profile (Picture, Name, change password)
- [✅] Send Notificatoin (In App) to Administrator everytime a company or employee is created
- [✅] Settings for Administrator to enable or disable notifications (Email or In App)
- [✅] Update about how to use the application