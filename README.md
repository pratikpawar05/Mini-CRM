## MINI-CRM

# Functionality:-

- [✅] Basic testing with phpunit.
- [✅] Use Laravel make:auth as default Bootstrap-based design theme, but remove ability to register.
- [✅] Companies DB table consists of these fields: Name (required), email, logo (minimum 100×100), website.
- [✅] Employees DB table consists of these fields: First name (required), last name (required), Company (foreign key to Companies), email, phone.
- [✅] Use database migrations to create those schemas above
- [✅] Use database seeds to create first user with email admin@admin.com and password “password”
- [✅] Basic Laravel Auth: ability to log in as administrator
- [✅] Use basic Laravel resource controllers with default methods – index, create, store etc.
- [❎] CRUD functionality (Create / Read / Update / Delete) for two menu items: Companies and Employees.
- [❎] Store companies logos in storage/app/public folder and make them accessible from public.
- [❎] Use Laravel’s validation function, using Request classes.
- [❎] Use Laravel’s pagination for showing Companies/Employees list, 10 entries per page.
- [❎] Use Datatables.net library to show table – with server-side rendering.
- [❎] Email notification: send email whenever new company is entered (use Mailgun or Mailtrap).
