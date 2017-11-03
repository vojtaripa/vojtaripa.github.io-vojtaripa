<?php
    require_once('Person.php');
    
    // Using the php wrapper for google charts
    function draw_bar_graph($width, $height, $data, $max_value)
    {
        require_once('gChart.php');

        // Need to separate the y values from the x labels
        // The labels are the keys, the values are the y values
        $myArray = array_values($data);
        $xLabels = array_keys($data);

        // This sets up the chart of google charts
        $barChart = new gBarChart();
        $barChart->addDataSet($myArray);            // add the y values
        $barChart->setAutoBarWidth();
        $barChart->setColors(array("ff3344", "11ff11", "22aacc"));
        $barChart->setGradientFill('c',0,array('FFE7C6',0,'76A4FB',1));
        $barChart->setDimensions($width, $height);
        $barChart->setVisibleAxes(array('x','y'));
        $barChart->setDataRange(0, $max_value);
        $barChart->addAxisRange(1, 0, $max_value);
        $barChart->addAxisLabel(0, $xLabels);       // Add the labels

        // Interesting, google charts creates an image from their site
        echo "<img src=" . $barChart->getUrl() . " /> <br>";

    } // End of draw_bar_graph() function


    // The books example of how to draw a chart, with a change to how the data
    // is organized
    function draw_bar_graph2($width, $height, $data, $max_value, $filename)
    {
        // Create the empty graph image
        $img = imagecreatetruecolor($width, $height);

        // Set a white background with black text and gray graphics
        $bg_color = imagecolorallocate($img, 255, 255, 255);       // white
        $text_color = imagecolorallocate($img, 255, 255, 255);     // white
        $bar_color = imagecolorallocate($img, 0, 0, 0);            // black
        $border_color = imagecolorallocate($img, 192, 192, 192);   // light gray

        // Fill the background
        imagefilledrectangle($img, 0, 0, $width, $height, $bg_color);

        // Draw the bars
        $bar_width = $width / ((count($data) * 2) + 1);
        $xLabels = array_keys($data);
        for ($i = 0; $i < count($data); $i++)
        {
            imagefilledrectangle($img, ($i * $bar_width * 2) + $bar_width, $height,
                ($i * $bar_width * 2) + ($bar_width * 2),
                 $height - (($height / $max_value) * $data[$xLabels[$i]]), $bar_color);
            imagestringup($img, 5, ($i * $bar_width * 2) + ($bar_width), $height - 5, $xLabels[$i], $text_color);
        }

        // Draw a rectangle around the whole thing
        imagerectangle($img, 0, 0, $width - 1, $height - 1, $border_color);

        // Draw the range up the left side of the graph
        for ($i = 1; $i <= $max_value; $i++)
        {
            imagestring($img, 5, 0, $height - ($i * ($height / $max_value)), $i, $bar_color);
        }

        // Write the graph image to a file
        imagepng($img, $filename, 5);
        imagedestroy($img);
    } // End of draw_bar_graph2() function


    $title = 'Student Information';
    require_once('Header.php');
?>

    <!-- start the table. -->
    <table width='800px' border='1' cellspacing='0' cellpadding='0'><tr><th width='50px'>Delete</th><th width='50px'>Edit</th><th width='75px'>First Name</th>
    <th width='75px'>Last Name</th><th width='40px'>Grade</th><th width='55px'>Email</th><th width='130px'>Comments</th></tr>

<?php 
    $people = Person::getList();
    
    $graphData = array();
    $graphData2 = array(array());
    foreach($people as $person)
    {
        echo "<tr><td><form method=\"POST\" action=\"delete.php?id=$person->id\"> ";
        echo "<input type='submit' value='Delete' name='delete' /></form></td>";
        
        echo "<td><form method=\"POST\" action=\"edit.php?id=$person->id\"> ";
        echo "<input type='submit' value='Edit' name='edit' /></form></td>";
         
        echo "<td>$person->firstname</td>";
        echo "<td>$person->lastname</td><td>$person->grade</td>";
        echo "<td>$person->email</td><td>$person->comments </td></tr>";


        // One way to count the number of students with each grade
        //   This method does not assume the data is sorted
        // Does an entry with that grade as key already exist
        if(array_key_exists($person->grade, $graphData))
            $graphData[$person->grade]++;       // Yes, increment it
        else
            $graphData[$person->grade] = 1;     // No, set it to one
    }
?>
 
<!-- close the table. --> 
   </table><br />

<br><br>

<?php
    draw_bar_graph(480, 240, $graphData, 5);

    // Dump the data just so we can see how it is organized
    var_dump($graphData);

    // The file name of this image has to be unique for each user so they don't
    // collide.  The books example uses UserId gotten from the session.  I don't have
    // a session or UserId so I used a unique number.  There is a problem though,
    // these graph images will just keep accumulating, bad.  Could put the generation of
    // the graph in a separate file and display it like a Captcha, that way a graph
    // image is not left around.
    $fileName = './images/' . $_SERVER['UNIQUE_ID'] . '-graph2.png';
    draw_bar_graph2(480, 240, $graphData, 5, $fileName);
    echo '<br><br><img src="' . $fileName . '" alt="Grade graph" /><br />';

    require_once('Footer.php');
?>
