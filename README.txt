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
- Installing PHPUnit
Before you can use the Geeklog PHPUnit test package, you need to install PHPUnit. I'm using Windows 7 RC with xampplite, and these instructions worked perfectly: http://blog.airness.de/2008/11/12/installing-phpunit-in-xampp/.
If, like me, you receive an error saying your PEAR installer is out of date, enter 'pear upgrade --force PEAR' in your console, then proceed through the installation. 
You can find more information on installing PHPUnit at http://www.phpunit.de/manual/. 
    
- Installing Test Package

1. Download the test package by going to http://project.geeklog.net/cgi-bin/hgwebdir.cgi/gsoc-2009-sclark/, and click the 'gz' link.

2. Unzip the files.

3. Place the folder 'testpackage' in your Geeklog root, and the folder 'tests' under Geeklog's public_html folder.
Note: the testpackage folder can go anywhere, but it is not reccomended to have it in an web-accessible directory for security.

4. Open testpackage/config.php. Here are the three paths you need to configure. 
    A. Under $public, enter the path to Geeklog's public_html folder, e.g: 'c:/xampplite/htdocs/public_html/'.
    B. Under $root, enter the path to Geeklog's root folder, where the main Geeklog files reside, e.g: 'c:/xampplite/geeklog/'.
    C. Under $tests, enter the path to the testpackage folder you just placed, e.g: 'c:/xampplite/geeklog/testpackage/'.
    Note: Use absolute paths!

5. Open public_html/tests/config.php. Change the require_once path to /path/to/testpackage/config.php.

6. WHILE IN DEVELOPMENT: replace the files in your geeklog installation with the files in 'replace'. This will probably either be taken care of by an install script in the future, or be permanently changed in Geeklog. For now, just copy and paste (you may want to back up your original files). 

 
III. USE

    1. Running tests
    You have two ways you can run your tests. One is by using a simple GUI included with the test package, and the second is by using the command line. 
    Note: The GUI only fully supports Firefox >3 with javascript enabled. The barest of functionality is offered without javascript enabled in tests/gui/index.php, but it is ugly. Be warned!
    To use the GUI, navigate with your browser to the tests folder in your Geeklog site (e.g: http://localhost/public_html/tests). You should be at a page called index_js.php (if you have javascript turned off, index.php). Under the left panel titled 'Run Tests' is a tree structure of all available tests for the Geeklog test framework. Select any number of tests you like (if you choose a folder, all the tests inside will be included), choose to have the console output returned and logs created (reccomended), and click 'Run Tests'. It may take a few minutes, so be patient.
    To your tests using your console, open the console and navigate to the public_html/tests folder. From here, you can type 'phpunit (path/to/testclass/testname)', and the test you specify will be run, with the results displayed in the console. If you specify a folder, all tests inside will be run. 
Note: this will only work if you are in the tests root folder (with config.php). This is because of the path structure.
You can find more information in the PHPUnit manual, at http://www.phpunit.de/manual/3.3/en/textui.html.

2. Viewing logs
    If you are running tests with the GUI, or using the correct path in the --log-json console runner, the event will be logged in testpackage/logs/masterlog.txt, and JSON logs will be created in the same folder with information for the event. You can view these logs using the 'View logs' panel in the GUI, select the logs you want to view and press 'View'. Alternatively, you can delete old logs by selecting the logs and - you got it - pressing 'Delete'.
IV. DETAILS     
1. Structure
    Here is the file structure of the test suite:    
    -testpackage (files which should be outside webroot)
        -files
            -classes (Geeklog test framework classes)
            -databases (XML 'dummy' databases for testing use)
            -dummy (Dummy file structure, this makes the test framework run on Geeklog files without Geeklog needing to be installed)
        -logs (Logs of tests run)
        -suite (This is where all the test classes are actually stored)
            -geeklog
                -public_html
                -system
                    -classes
    -tests (This should be in your webroot)
        -gui (Files for GUI)
    -css
    -development-bundle
    -images
    -jobs (Scripts user by GUI and cronjobs, etc. can be pointed at to interact with test             framework)
    -js

 2. Working with databases    
    This test package is designed to work with or without a Geeklog install. It does this by using the configuration paths you specified in the installation, and by using a XML version of Geeklog's SQL database. To write tests for a file requiring database calls, first ensure that default.xml exists (in testpackage/files/databases). This is the XML version of Geeklog's database, as appears after a fresh install. The class that handles the operations (done with simpleXML and xPath) on the database is xmldb.class.php, under testpackage/files/databases. 
    
    You can use xmldb.class.php in three steps.
    1. Require config.php, e.g: require_once 'config.php'. You should be doing this anyway.
    2. Require the file, e.g: require_once getPath('tests').'/files/databases/xmldb.class.php'. 
    3. Create an object, e.g: $this->xml = new Xmldb;
    4. Call the function you want, providing the database you want to load as the parameter, e.g: $_CONF = $this->xml->get_CONF('database'). If you don't specify a database, it will load default.xml.
    
    3. Adding tests
    This will integrate new PHPUnit tests with the Geeklog test framework, (for example, if you wanted to write your own tests for Geeklog files and add them to the suite).
1) Save your test to the correct folder. Under testpackage/suite is a folder named 'geeklog'. This contains tests for Geeklog files in a folder structure mirroring that of a typical Geeklog installation. For example, lib-common.php is located under geeklog/public_html, so you would save its test under testpackage/files/suite/geeklog/public_html.  Name it as [filename]Test.php (a test for lib-common would be lib-commonTest.php).
    
2)     Add these lines at the beginning of your file:
        require_once 'PHPUnit/Framework.php';
        require_once 'config.php';
        
    These will implement the PHPUnit framework and Geeklog's framework config file.

3) Now, require the class you are writing a test for, e.g:
    require_once TestConfig::$root.'system/lib-mbyte.php';
        
    If you are using the XML database, add this line:
        require_once TestConfig::$tests.'files/classes/xmldb.class.php';
                
    Your test should be ready to run!

4. Adding jobs
    With a few lines of code, you can interact with the Geeklog test framework's test running and logging system. These scripts are typically stored under tests/gui/jobs. You can browse through the existing scripts and tests.class.php to see how they work and are implemented. Let's take 'tests/gui/jobs/runAll.php' as an example.    
1) These two lines at the beginning of the script include Geeklog's test framework config file and tests class:
    require_once 'config.php';
    require_once TestConfig::$tests.'files/classes/tests.class.php';
2) This creates an instance of tests.class.php:
    $tests = new Tests;
3) Now we can perform any action on the test framework already scripted in tests.class.php, if you need to do something not already provided in this class, add it if you think it may be useful to other people. If it's something that will only be used once, just put it in the script. In this example, we tell $tests->runTests() to run tests on all files under 'suite', create a JSON log for the output, and discard the console output. A cronjob could be pointed at this and run it on a specified schedule.

V. RESOURCES
    PHPUnit manual: http://www.phpunit.de/manual/current/en/    

VI. DEVELOPMENT IDEAS
    Given the limited amount of time available for me to put together this package, here are some of the things I would like to eventually see (if any aspiring developer wants to continue working on this test package). These are not necessarily in order of importance.
    
1. The GUI could use help in the following ways:
    - Debugged to work in all major browsers. (Firefox is the only one currently supported).
     - Make it look nice. It's ugly right now, and that's because my priority right now isn't to design a nice interface.
            - Graphs and more extensive charts, could be extremely useful when testing on a larger scale. I believe jQuery offers plugins that will do this, and the GUI has jQuery bundled with it. PHPUnit offers a variety of options for collecting test results which I haven't completely looked into.
            - An option to use a text input box to run tests, like a console replacement, would be useful as well: PHPUnit offers a variety of command-line runners that would clutter the interface, should they be offered on a point-and-click basis.         
2. Offering the option to test with or without a SQL database. Right now, the suite is design to run with only an XML database, which keeps it from needing a full Geeklog installation. For live setups, it would be most useful to be able to run the tests with the SQL database as well. This could throw complications for tests that involved writing to a database, however...
    
3. A script that offered to convert the client's SQL database to an XML database would be a useful alternative to the SQL database; perhaps even more effective, as the test suite may eventually be testing entries to the database (and we obviously don't want it to be modifying an existing SQL database). PHPMyAdmin has such a feature. 
    
    4. An install script. Setting up the suite isn't very complex right now, but a simple user-friendly interface running on an install script would make the setup much easier and with less risk of user input error. It would also make updates to the package much easier to implement, as overwriting the old suite by  hand with updates would be extremely difficult if the user customized any tests.
    
    5. The package would be much more user friendly if it checked the version of Geeklog, as different version suites will be necessary for different versions of Geeklog.
    
    6. More tests! Geeklog has an extensive code base that would be extremely difficult for one person to completely cover with tests. 