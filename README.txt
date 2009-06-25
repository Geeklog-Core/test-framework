Test Framework Package for Geeklog

_________________________________________

Table of Contents

I.   Introduction
II.  Installation
III. Use
IV.  Details
V.   Resources
VI.  Development Ideas

_________________________________________

I. INTRODUCTION
(WHAT IS PHPUNIT, WHY USE, ETC.)


II. INSTALLATION
    (ADD HOW TO INSTALL PHPUnit)
1. Download the test package by going to http://project.geeklog.net/cgi-bin/hgwebdir.cgi/gsoc-2009-sclark/, and click the 'gz' link.

2. Unzip the files.

3. Place the folder 'testpackage' in your Geeklog root, and the folder 'tests' under Geeklog's public_html folder.
Note: the testpackage folder can go anywhere, but it is not reccomended to have it in an web-accessible directory for security.

4. Open testpackage/config.php. Here are the three paths you need to configure. 
    A. Under case 'public', enter the path to Geeklog's public_html folder, i.e: 'c:/xampplite/htdocs/public_html'.
    B. Under case 'root', enter the path to Geeklog's root folder, where the main Geeklog files reside, i.e: 'c:/xampplite/geeklog'.
    C. Under case 'tests', enter the path to the testpackage folder you just placed,     i.e: 'c:/xampplite/geeklog/testpackage'.
    Note: Use absolute paths, and don't add trailing slashes!

5. Open public_html/tests/config.php. Change the require_once path to /path/to/testpackage/config.php.

6. WHILE IN DEVELOPMENT: replace the files in your geeklog installation with the files in 'replace'. This will probably either be taken care of by an install script in the future, or be permanently changed in Geeklog. For now, just copy and paste (you may want to back up your original files). 

 
III. USE

	1. Running tests

    You have two ways you can run your tests. One is by using a simple GUI included with the test package, and the second is by using 
the command line. 
    Note: You will need to have javascript enabled to use the GUI.

    To use the GUI, navigate with your browser to the tests folder in your Geeklog site (i.e: http://localhost/public_html/tests). On 
the left of the page is a folder tree displaying the test directories. Notice that the directory is a copy of the Geeklog file structure, 
except with test classes rather than the original file. Click on a directory to open it, click it again to close it. Click the checkbox 
next to a file to have it included in your round of tests. Clicking a folder will automatically include all tests inside. 
    Once you have chosen the tests to run, click 'Test Files'. A box saying 'Results' will appear on the right side of the screen, 
showing the default PHPUnit console output. (ADD MORE INFORMATION ON WHERE TO FIND CONSOLE OUTPUT). Detailed results will also show up 
underneath, showing each test run, the result (pass or fail), the time taken to run, the line of the test class the test appears on, the 
assertions made by each test, and the error message (if any). 

(ADD INFORMATION ABOUT LIMITATIONS AND BUGS).

    To your tests using your console, open the console and navigate to the public_html/tests folder. From here, you can type 'phpunit 
(path/to/testclass/testname)', and the test you specify will be run, with the results displayed in the console. If you specify a folder, 
all tests inside will be run. (WHERE TO FIND INFORMATION ON CONSOLE COMMANDS).
Note: this will only work if you are in the tests root folder (with config.php). This is because of the path structure.
	

IV. DETAILS
    (STRUCTURE, HOW TO WRITE TESTS TO WORK WITH FRAMEWORK, ETC.)
	
	1. Structure
	Here is the file structure of the test suite:
	
	-testpackage
		-files
			-classes
			-databases
			-dummy
		-logs
		-suite
			-geeklog
				-public_html
				-system
					-classes
	-tests
		-gui
	
	2. Working with databases
	
	This test package is designed to work with or without a Geeklog install. It does this by using the configuration paths you specified in the installation,
and by using a XML version of Geeklog's SQL database. To write tests for a file requiring database calls, first ensure that default.xml exists (in testpackage/files/databases). This is the XML version of Geeklog's database, as appears after a fresh install. The class that handles the operations (done with simpleXML and xPath) on the database is xmldb.class.php, under testpackage/files/databases. 
	
	You can use xmldb.class.php in three steps.
	1. Require config.php, i.e: require_once 'config.php'. You should be doing this anyway.
	2. Require the file, i.e: require_once getPath('tests').'/files/databases/xmldb.class.php'. 
	3. Create an object, i.e: $this->xml = new Xmldb;
	4. Call the function you want, providing the database you want to load as the parameter, i.e: $_CONF = $this->xml->get_CONF('database'). If you don't specify a database, it will load default.xml.


V. RESOURCES
    (LINKS TO PHPUNIT INFORMATION). 
    
VI. DEVELOPMENT IDEAS

    Given the limited amount of time available for me to put together this package, here are some of the things I would like to eventually see (if any aspiring developer wants to continue working on this test package). These are not necessarily in order of importance.
    
    1. The GUI offers the absolute barest of functionalities right now. Some useful additions to it would be:
		- Make it look nice. It's ugly right now, and that's because my priority right now isn't to design a nice interface.
        - The page uses AJAX, but the code is terrible - the code for tests/index.php and tests/runTests.php needs to be cleaned.
		- There's problems with the layout; things overlap on occasion, and they shouldn't. It would also be nice to have test class names with the appropriate data. The whole interface could use a lot more time. 
        - Graphs and more extensive charts, could be extremely useful when testing on a larger scale. I believe jQuery offers plugins that will do this, and the GUI has jQuery bundled with it. PHPUnit offers a variety of options for collecting test results which I haven't completely looked into.
        - The advanced results table could something of its own 'tree structure' using javascript, to prevent the enormous page that would result from 50+ test classes and make the results more manageable. 
        - An option to use a text input box to run tests, like a console replacement, would be useful as well: PHPUnit offers a variety of command-line runners that would clutter the interface, should they be offered on a point-and-click basis. 
        - In addition (or alternatively), there could be a row of checkboxes asking which runners the person testing wants to implement (HTML results, XML results, etc.).
        
    2. Offering the option to test with or without a SQL database. Right now, the suite is design to run with only an XML database, which keeps it from needing a full Geeklog installation. For live setups, it would be most useful to be able to run the tests with the SQL database.
    
    3. A script that offered to convert the client's SQL database to an XML database would be a useful alternative to the SQL database; perhaps even more effective, as the test suite may eventually be testing entries to the database (and we obviously don't want it to be modifying an existing SQL database). PHPMyAdmin has such a feature. 
    
    4. An install script. Setting up the suite isn't very complex right now, but a simple user-friendly interface running on an install script would make the setup much easier and with less risk of user input error. It would also make updates to the package much easier to implement, as overwriting the old suite by  hand with updates would be extremely difficult if the user customized any tests.
    
    5. The package would be much more user friendly if it checked the version of Geeklog, as different version suites will be necessary for different versions of Geeklog.
    
    6. More tests! Geeklog has an extensive code base that would be extremely difficult one person to completely cover with tests. 
