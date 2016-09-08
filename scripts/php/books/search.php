<?php

require_once('../../../include/connect.inc.php');
require_once('../../../include/core.inc.php');
require_once('../../../include/table.inc.php');

$_GET=sqlEscape($_GET);   //SQL injection safe

$html=false;

if(isset($_GET['type'])&&isset($_GET['category'])&&isset($_GET['keyword'])){
    $type=$_GET['type'];
    $category=$_GET['category'];
    if($type=="books"){
        if($category=="name"){
            $category="bookname";
        }
        $sql="SELECT l.bookname,l.id,l.author,IFNULL(l.publication,'N/A') AS publication,price,IFNULL(i.userid,'Available') AS status 
        FROM libbooks l 
        LEFT OUTER JOIN issues i on l.id=i.bookid 
        LEFT OUTER JOIN libusers u ON u.id=i.userid 
        WHERE l.$category like '$_GET[keyword]%'";
        $result=new CTable();
        $html=$result->drawTable(['Book Name','ID','Author','Publisher','Price','Status'],false,$sql);
    }
    else if($type=="journals"){

        $tableHeader="<table id='libjournals' class='table table-stripped table-hover'>
                                    <thead>
                                         <th>ID</th>
                                         <th>Name</th>
                                         <th>Title</th>
                                         <th>Authors</th>
                                         <th>Month</th>
                                         <th>Acadamic Year</th>
                                         <th>Issue</th>
                                         <th>Volume</th>
                                         <th>Impact Factor</th>                                                             
                                         <th>PDF</th>
                                    </thead>";
        $tableFooter="<tfoot>                       
                        <th>ID</th>           
                        <th>Name</th>
                        <th>Title</th>
                        <th>Authors</th>
                        <th>Month</th> 
                        <th>Acadamic Year</th>
                        <th>Issue</th>
                        <th>Volume</th>                                    
                        <th>Impact Factor</th>                                    
                        <th>PDF</th>
                        </tfoot>
                    </table>";

        $tableBody="<tbody>";
        if($category=="name"){
            $sql="SELECT * FROM libjournals WHERE journalname LIKE '$_GET[keyword]%' OR journaltitle LIKE '%$_GET[keyword]%' OR month = '$_GET[keyword]' OR year_from = '$_GET[keyword]' OR year_to = '$_GET[keyword]'";
            if($result=mysql_query($sql)){
                if(mysql_num_rows($result)>0){
                    while($journal=mysql_fetch_assoc($result)){
                        $journalAuthors=[];
                        $sql="SELECT u.username FROM journal_authors j JOIN libusers u ON j.userid=u.id AND j.journalid='$journal[id]'";
                        if($author_result=mysql_query($sql)){
                            while($author=mysql_fetch_assoc($author_result)){
                                array_push($journalAuthors,$author['username']);
                            }
                            $journalAuthors=implode(",",$journalAuthors);
                        }
                        $pdfButton="<div class='input-group'>
                                        <div class='input-group-btn'>
                                            <a href='scripts/php/journals/pdf/$journal[id].pdf' target='_blank' class='btn btn-primary'><span class='glyphicon glyphicon-eye-open'></span></a>
                                        </div>
                                    </div>";
                        $tableBody.="<tr class='libjournals-row'>
                                        <td>$journal[id]</td>
                                        <td>$journal[journalname]</td>
                                        <td>$journal[journaltitle]</td>
                                        <td>$journalAuthors</td>
                                        <td>$journal[month]</td>
                                        <td>$journal[year_from]-$journal[year_to]</td>
                                        <td>$journal[issue]</td>
                                        <td>$journal[volume]</td>
                                        <td>$journal[impactfactor]</td>
                                        <td>$pdfButton</td>
                                        </tr>";
                    }
                    $tableBody.="</tbody>";
                    $html=$tableHeader.$tableBody.$tableFooter;  
                }                      
            }
        }
        else if($category=="author"){
            $sql="SELECT * FROM libusers WHERE username LIKE '$_GET[keyword]%'";
            $condition="";            
            if($authors=mysql_query($sql)){
                if(mysql_num_rows($authors)>0){
                    while($author=mysql_fetch_assoc($authors)){
                        if($condition==""){
                            $condition=" WHERE userid = '".$author['id']."'";
                        }
                        else{
                            $condition.=" OR userid = '".$author['id']."'";
                        }
                    }
                    $sql="SELECT * FROM libjournals WHERE id IN 
                    ( SELECT DISTINCT journalid FROM libjournals j JOIN journal_authors a ON j.id=a.journalid".$condition." )";
                    if($result=mysql_query($sql)){
                        if(mysql_num_rows($result)>0){
                            while($journal=mysql_fetch_assoc($result)){
                                $journalAuthors=[];
                                $sql="SELECT u.username FROM journal_authors j JOIN libusers u ON j.userid=u.id AND j.journalid='$journal[id]'";
                                if($author_result=mysql_query($sql)){
                                    while($author=mysql_fetch_assoc($author_result)){
                                        array_push($journalAuthors,$author['username']);
                                    }
                                    $journalAuthors=implode(",",$journalAuthors);
                                }
                                $pdfButton="<div class='input-group'>
                                                <div class='input-group-btn'>
                                                    <a href='scripts/php/journals/pdf/$journal[id].pdf' target='_blank' class='btn btn-primary'><span class='glyphicon glyphicon-eye-open'></span></a>
                                                </div>
                                            </div>";
                                $tableBody.="<tr class='libjournals-row'>
                                                <td>$journal[id]</td>
                                                <td>$journal[journalname]</td>
                                                <td>$journal[journaltitle]</td>
                                                <td>$journalAuthors</td>
                                                <td>$journal[month]</td>
                                                <td>$journal[year_from]-$journal[year_to]</td>
                                                <td>$journal[issue]</td>
                                                <td>$journal[volume]</td>
                                                <td>$journal[impactfactor]</td>
                                                <td>$pdfButton</td>
                                                </tr>";
                            }
                            $tableBody.="</tbody>";
                            $html=$tableHeader.$tableBody.$tableFooter;                     
                        }   
                    }
                }
            }
        }
        else if($category=="id"){
            $sql="SELECT * FROM libjournals WHERE id LIKE '$_GET[keyword]%'";
            if($result=mysql_query($sql)){
                if(mysql_num_rows($result)>0){
                    while($journal=mysql_fetch_assoc($result)){
                        $journalAuthors=[];
                        $sql="SELECT u.username FROM journal_authors j JOIN libusers u ON j.userid=u.id AND j.journalid='$journal[id]'";
                        if($author_result=mysql_query($sql)){
                            while($author=mysql_fetch_assoc($author_result)){
                                array_push($journalAuthors,$author['username']);
                            }
                            $journalAuthors=implode(",",$journalAuthors);
                        }
                        $pdfButton="<div class='input-group'>
                                        <div class='input-group-btn'>
                                            <a href='scripts/php/journals/pdf/$journal[id].pdf' target='_blank' class='btn btn-primary'><span class='glyphicon glyphicon-eye-open'></span></a>
                                        </div>
                                    </div>";
                        $tableBody.="<tr class='libjournals-row'>
                                        <td>$journal[id]</td>
                                        <td>$journal[journalname]</td>
                                        <td>$journal[journaltitle]</td>
                                        <td>$journalAuthors</td>
                                        <td>$journal[month]</td>
                                        <td>$journal[year_from]-$journal[year_to]</td>
                                        <td>$journal[issue]</td>
                                        <td>$journal[volume]</td>
                                        <td>$journal[impactfactor]</td>
                                        <td>$pdfButton</td>
                                        </tr>";
                    }
                    $tableBody.="</tbody>";
                    $html=$tableHeader.$tableBody.$tableFooter;  
                }                      
            }
        }
    }
}


$response=['html'=>$html];

echo(json_encode($response));

?>