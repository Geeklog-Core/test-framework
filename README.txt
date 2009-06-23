Test Framework Package for Geeklog

_________________________________________

Table of Contents

I.   Introduction
II.  Installation
III. Use
IV.  Details
V.   Resources

_________________________________________

I. INTRODUCTION
(WHAT IS PHPUNIT, WHY USE, ETC.)


II. INSTALLATION
    (ADD HOW TO INSTALL PHPUnit)
1. Download the test package by going to http://project.geeklog.net/cgi-bin/hgwebdir.cgi/gsoc-2009-sclark/, and click the 'gz' link.

2. Unzip the files.

3. Place the folder 'testpackage' in your Geeklog root, and the folder 'tests' under Geeklog's public_html folder.
Note: the testpackage folder can go anywhere, but it is not reccomended to have it in an web-accessible directory for security.

4. Open testpackage/config.php. Here we have three paths you need to configure. 
    A. Under case 'public', enter the path to Geeklog's public_html folder, i.e: 'c:/xampplite/htdocs/public_html'.
    B. Under case 'root', enter the path to Geeklog's root folder, where the main Geeklog files reside, i.e: 'c:/xampplite/geeklog'.
    C. Under case 'tests', enter the path to the testpackage folder you just placed,     i.e: 'c:/xampplite/geeklog/testpackage'.
    Note: Use absolute paths, and don't add trailing slashes!

5. Open public_html/tests/config.php. Change the require_once path to /path/to/testpackage/config.php.

 
III. USE
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


V. RESOURCES
    (LINKS TO PHPUNIT INFORMATION). 
