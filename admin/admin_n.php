<?php
    declare(strict_types=1);
    require_once '../includes/dbh.inc.php';

    $query="SELECT *FROM hackathon_data WHERE H_id IN (
        SELECT H_id
        FROM judges_data
    )
    AND H_id IN (
        SELECT H_id
        FROM criteria_data
    );
    ";
    $stmt=$pdo->prepare($query);
    $stmt->execute();
    $result=$stmt->fetchAll();
    $stmt->execute();
    if($result){
       
?>
    <table>
       <tr>
            <th>Hackathon ID</th>
            <th>Hackathon Name</th>
            <th>Date</th>
            <th>Time</th>
            
        </tr>
        <?php
        foreach($result as $row){ ?>
            <tr>
                    <td><?php echo $row['H_id'] ?></td>
                    <td><?php echo $row['HName'] ?></td>
                    <td><?php echo $row['HDate'] ?></td>
                    <td><?php echo $row['HTime'] ?></td>
                    
            </tr>
         <?php  }   ?>
        </table>


    <?php } else{ ?>
        <table>
        
       <tr>
       <td><h1 style="color: #F73634;">No hackathons</h1></td>

    </tr> </table>
    <?php } ?>
