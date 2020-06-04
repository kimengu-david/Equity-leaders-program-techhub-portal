# Equity-leaders-program-techhub-portal

### Table of contents.</br>

#### 1.Introduction.</br>
#### 2.Technologies. </br>
#### 3.Prerequisites. </br>
#### 3.Installation.</br> 
#### 5.Contribution. </br>
#### 5.Maintainers. </br>



### Introduction </br>
The ELP techhub web portal is a project meant for management of Equity leaders program scholars in tech and tech related fields.</br>
It makes it easier for members to sign up for meetups, join project teams, get internal job advertisements and news all in real  time.</br>The management of the team is also able to generate daily reports in form of pdf and online versions. All these features come in a creatively designed dashboard which is accessible after login.


### Main Technologies </br>
1.Laravel 6.0.</br>
2.Vuejs 2.0.</br>
3.Php 7.2</br>
4.Bootstrap 4.0.</br>
5.Jquery 3.2. </br>
6.Axios 0.19.2 </br>.


### Prerequisites </br>
Install node package manager.
```bash
npm install npm@latest -g
```
Run the following command to install php and all the required php modules.
```bash
sudo apt install php7.2-common php7.2-cli php7.2-gd php7.2-mysql php7.2-curl php7.2-intl php7.2-mbstring php7.2-bcmath php7.2-imap php7.2-xml php7.2-zip
```
Install composer globally, download the Composer installer with curl and move the file to the /usr/local/bin directory:
```bash
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
```
Very the installation by printing the composer version.
```bash
composer --version
```
### Installation. </br>.

1.Clone the repo and navigate to the downloaded folder.
```bash
git clone https://github.com/kimengu-david/Equity-leaders-program-techhub-portal
```
2.Install npm packages.
```bash
npm install
```
3.Install composer packages.
```bash
composer install
```
4.Configure your database credentials in database.php file of the config folder.</br>
6.Perform database migrations by running the following command.
```bash.
php artisan migrate
```
5.You can start the development server by executing the following command:
```bash
php artisan serve
```
6.Open your browse and type http://127.0.0.1:8000 and assuming the installation is successful, You should be able to see the homepage.




### Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.</br>
Any contributions that you make are greatly appreaciated.
  

### Contact.
David Mutune -davidmutune200@gmail.com





 
