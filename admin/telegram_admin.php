<?php
require 'header.php';
?>



<?php

// DmhMailer::send('Mats.rappe@yahoo.se', 'Mats Rappe', "Det här är ett mail");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $operation = $_POST['operation'];
     //echo $operation;
    if ($operation == 'insert') {
        $telegram = Telegram::newFromArray($_POST);
        $telegram->create();
    } elseif ($operation == 'delete') {
        Telegram::delete($_POST['Id']);
    } elseif ($operation == 'update') {
        $telegram = Telegram::newFromArray($_POST);
        $telegram->update();
    } else {
        echo $operation;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
//     $operation = $_GET['operation'];
    if (isset($_GET['operation']) && $_GET['operation'] == 'delete') {
        Telegram::delete($_GET['id']);
    }
}

?>
        <nav id="navigation">
          <a href="#" class="logo"><?php echo $current_larp->Name;?></a>
          <ul class="links">
            <li><a href="index.php"><i class="fa-solid fa-house"></i></i>Hem</a></li>
        	<li><a href="../includes/logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logga ut</a></li>
          </ul>
        </nav>

    <div class="content">
        <h1>Telegram</h1>
            <a href="telegram_form.php?operation=new"><i class="fa-solid fa-file-circle-plus"></i>Lägg till</a>  
        
            <a href="telegram_pdf.php"><i class="fa-solid fa-file-pdf"></i>Generera pdf</a>  
        
        <?php
    
        $telegram_array = Telegram::allBySelectedLARP();
        if (!empty($telegram_array)) {
            echo "<table id='telegrams' class='data'>";
            echo "<tr><th>Id</td><th>Leveranstid</th><th>Avsändare</th><th>Avsändarens stad</th><th>Mottagare</th><th>Mottagarens stad</th><th>Meddelande</th><th>Anteckningar</th><th></th><th></th></tr>\n";
            foreach ($telegram_array as $telegram) {
                echo "<tr>\n";
                echo "<td>" . $telegram->Id . "</td>\n";
                echo "<td>" . $telegram->Deliverytime . "</td>\n";
                echo "<td>" . $telegram->Sender . "</td>\n";
                echo "<td>" . $telegram->SenderCity . "</td>\n";
                echo "<td>" . $telegram->Reciever . "</td>\n";
                echo "<td>" . $telegram->RecieverCity . "</td>\n";
                echo "<td>" . str_replace("\n", "<br>", $telegram->Message) . "</td>\n";
                echo "<td>" . str_replace("\n", "<br>", $telegram->OrganizerNotes) . "</td>\n";
                
                echo "<td>" . "<a href='telegram_form.php?operation=update&id=" . $telegram->Id . "'><i class='fa-solid fa-pen'></i></td>\n";
                echo "<td>" . "<a href='telegram_admin.php?operation=delete&id=" . $telegram->Id . "'><i class='fa-solid fa-trash'></i></td>\n";
                echo "</tr>\n";
            }
            echo "</table>";
        }
        else {
            echo "<p>Inga registrarade ännu</p>";
        }
        ?>
    </div>
	
</body>

</html>