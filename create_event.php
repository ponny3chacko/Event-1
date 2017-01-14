<?php
    ini_set('upload_max_filesize', '10M');
    include'header.php';
    if(!isset($_SESSION['id'])){        
        header('Location: /Home/Request');
    }
    $url = '';
    
    if(isset($_GET['event'])){
        if(isset($_SESSION['adminId']) && isset($_GET['pass'])){
            $url = '../../../../Show/'.$_GET['title'].'/'.$_GET['event'];    
        }else{
            if(isset($_SESSION['adminId'])){
                $url = '../../../Show/'.$_GET['title'].'/'.$_GET['event'];    
            }

            if(!isset($_SESSION["id"])){
                header('Location: '.$url);
            }else{        
                if(!checkAuthority($con,$_GET['event'],$_SESSION["id"])){
                    header('Location: '.$url);
                }
            }
        }
    }
        
    if(isset($_GET['event'])){
        $qry = "select * from event_details where e_id = ".$_GET['event'];
        $_SESSION['eId'] = $_GET['event'];
    }else{        
        $qry = "select * from event_details where user_id = ".$_SESSION['id']." and status = 1";
    } 
    $res = $con->query($qry);
    $count = $res->num_rows;
    $countT= 0;
    if($count == 0){

        $qry = "insert into event_details (user_id,start_date,end_date,event_city_id,status) values (".$_SESSION['id'].",'".$date."','".$date."',2763,1)";
        $res=$con->query($qry);            
        
        if($res){
            $_SESSION['eId'] = $con->insert_id;
            $qryT = "insert into ticket_details (tic_last_date,tic_e_id) values('".$date."',".$_SESSION['eId'].")";
            $resT = $con->query($qryT);  
            $_SESSION['tId'] = $con->insert_id;
        }   
    }else{
        $res=$con->query($qry);
        $row = $res->fetch_assoc();

        $_SESSION['eId'] = $row['e_id'];

        $qryT = "select * from ticket_details where tic_e_id = ".$_SESSION['eId'];
        $resT = $con->query($qryT);      
        $countT = $resT->num_rows;            
        
        if($countT == 0){
            $qryT = "insert into ticket_details (tic_last_date,tic_e_id) values('".$date."',".$_SESSION['eId'].")";
            $resT = $con->query($qryT);  
            $_SESSION['tId'] = $con->insert_id; 
        }else{
            $rowT = $resT->fetch_assoc();            
            $_SESSION['tId'] = $rowT['tic_id'];
        }

    }
?>

<div class="content">
    <div class="slider3 sld" id = "imagePreview" style="    background-position: center 100%;
    background-size: cover;background-image: url('<?php echo $row['banner_img']?>');">
        <div class="uploadLoad" id="uploadLoader"></div>
        <form id = "confirmImage" method="post" >
            <?php 
                $style = array();
                if($row['banner_img'] === '' || $row['banner_img'] == null){
                    $style[0] = 'display:block';
                    $style[1] = 'display:none';
                    // $style[2] = 'display:inline';
                } else{
                    $style[0] = 'display:none';
                    $style[1] = 'display:block';
                    // $style[2] = 'display:inline';
                }
            ?>
            <div class="errorImage">Upload Image of 1366 X 400 for Best Result</div>
            <div class="warning-error" id="errorImage" style = "display: none;">Upload Image of 1366 X 400 for Best Result</div>
            <input name="eventPic" class="upload" id="file-2" type="file" data-multiple-caption="{count} files selected" multiple="" accept="image/png, image/jpeg, image/jpg" style="display: none;">
            <label for="file-2" class="fileUpload upload" id = "uploadBanner"  title = "Upload your Event Banner" style="<?php echo $style[0];?>">
                <div>
                    <i class="fa fa-upload" aria-hidden="true"></i> Upload banner 
                </div>            
            </label>        
            <div class="mybanner" id = "bannerBtn"  style=";<?php echo $style[1];?>">
			
				
					<span id = "errLaMsg" class="someMsg">Something went Wrong. Please Try agian!</span>
					</br>
					
						<button type="submit" class="btn confirm" id = "doneBtn" style="<?php echo $style[0]?>">Confirm</button>            
						<label for="file-2" class="btn confirm2"  title = "Change Existing Banner of Event" >Change</label>  
					
				
            </div>
        </form>
    </div>
    <div class="descri"  id = "eventDescription">
        <h1>About Event <span class="loadingSpan" id = "editAbout" >Saving...</span></h1>
        
                <div id="description"></div>
        <!-- <button class="btn save">Save</button> -->
    </div>
    <div class="clearfix"></div>
    <div class="book-new ">
        <hr>
        <div>
            <div contenteditable="true" id="eventTitle" class="eventtitle" name = "title"  title = "Give a Event Title" class="inside-decri style-4" onclick="change(this.id);"  onkeyup = "getDivData($(this).attr('name'),this.id,'');">
            <?php echo $row['title'] == '' || $row['title'] == '<br>'? 'Add Event Title...' : $row['title']; ?>
            </div>                
        </div>     
        <!-- Ticket Section -->
        <div class="event-list1 loaded">
            <div id="tabs" class="tabs">
                <div class="content" style = "background: #fff;">            
                    <div id="section" class="content-current">
                        <h3 class="event-h3">Add Event Tickets </h3>                          
                        
                        <div class="clear"></div>
                        <div id = "ticketData">
                        <?php
                        $c = 1;
                        // echo $countT;
                        if($countT == 0) 
                        { 
                            ?>
                            <div class="ticket1" id="<?php echo $_SESSION['tId']; ?>">
                                <i class="fa fa-times-circle delete closebtn" onclick="deleteTicket($(this).closest('div').prop('id'));" aria-hidden="true"></i>
                                <div class="ticket-borderTop"> </div>
                                <div class="ticket-div-content">
                                    <div class="ticket-cont_main">                                
                                        <div class="ticket-eventCatName" style="color: grey">
                                            <div class="ticketName">
                                                <span id = "lticketName1">Ticket Title - </span>
                                                <input type="text" title = "Enter Title for Ticket" name = "" id = "ticketName1" onkeyup = "insertData(this.value,this.id,'<?php echo $_SESSION["tId"]; ?>');" placeholder = "Enter Ticket Name" onclick = "change(this.id,'drop');" onfocus = "change(this.id,'drop');" onblur = "$('#lticketName1').hide();"  onblur = "labelHide(this.id,'drop');"> 
                                            </div>
                                            <div class="clear"></div>
                                            <div class="ticket-tckdesc">
                                                <span id = "lticketDescription1">Ticket Description - </span>
                                                <input type="text" title = "Enter short Description for Ticket" id = "ticketDescription1" onkeyup = "insertData(this.value,this.id,'<?php echo $_SESSION["tId"]; ?>');" placeholder= "Enter Ticket description"  onclick = "change(this.id,'drop');" onfocus = "change(this.id,'drop');" onblur = "labelHide(this.id,'drop');">
                                            </div>
                                            <div  class="ticket-lastdate" >          
                                            <!-- id = "lticketLast_date1"                                -->
                                                <span  class= "ticSpan">Available from - </span>
                                                <input class= "ticDate" title = "Enter Last date for Tickets" type="text" id="ticketLast_date1" value="<?php echo date('dS M, Y',strtotime($date)); ?>" placeholder="Tickets Available from" onfocus="getDate(this.id);" onclick="getDate(this.id);" style="border:0px;background: rgba(204, 204, 204, 0);" onchange = "insertData(this.value,this.id,'<?php echo $_SESSION["tId"]; ?>');"  onclick = "change(this.id,'drop');" onfocus = "change(this.id,'drop');" onblur = "labelHide(this.id,'drop');">
                                                 <!-- id = "lticketLast_date1" -->
                                                <span  class= "ticSpan">Available Till - </span>
                                                <input  class= "ticDate" title = "Enter Last date for Tickets" type="text" id="ticketStart_date1" value="<?php echo date('dS M, Y',strtotime($date)); ?>" placeholder="Tickets Available Till" onfocus="getDate(this.id);" onclick="getDate(this.id);" style="border:0px;background: rgba(204, 204, 204, 0);" onchange = "insertData(this.value,this.id,'<?php echo $_SESSION["tId"]; ?>');"  onclick = "change(this.id,'drop');" onfocus = "change(this.id,'drop');" onblur = "labelHide(this.id,'drop');">
                                            </div>
                                        </div>
                                        <div class="ticket-eventCatValue">
                                            <span id = "lticketPrice1">Ticket Price</span>
                                            <input type = "text" style = "text-align:center;width: 100%" title = "Enter Price for Ticket" id= "ticketPrice1" onkeyup = "insertData(this.value,this.id,'<?php echo $_SESSION["tId"]; ?>');" placeholder = "Enter Price"  onclick = "change(this.id,'blind');" onfocus = "change(this.id,'blind');" onblur = "labelHide(this.id,'blind');">
                                        </div>
                                        <div class="ticket-eventCatSelect">
                                            <div>
                                                <span id = "lticketTotal1">Total Tickets</span>
                                                <input type="text" class="tquantity" title = "Enter Total Available Tickets to be Sold" id="ticketTotal1" onkeyup = "insertData(this.value,this.id,'<?php echo $_SESSION["tId"]; ?>');" placeholder = "Total Tickets"  onclick = "change(this.id,'blind');" onfocus = "change(this.id,'blind');" onblur = "labelHide(this.id,'blind');">
                                            </div>
                                            <div>
                                                <span id = "lticketMax1">Max Tickets</span>
                                                <input type = "text" class="tquantity" title = "Enter Max Allowed Tickets to be Purchased by Customer at a Time" id="ticketMax1" onkeyup = "insertData(this.value,this.id,'<?php echo $_SESSION["tId"]; ?>');" placeholder = "Max Tickets allow to book"  onclick = "change(this.id,'blind');" onfocus = "change(this.id,'blind');" onblur = "labelHide(this.id,'blind');">
                                            </div>
                                        </div>
                                    </div>                            
                                </div>                        
                                <div class="clear"></div>
                                <div class="ticket-borderBottom"></div>                                
                            </div>                        
                        <?php 
                        }else{
                            $resT = $con->query($qryT);
                            
                            
                            while ($rowT = $resT->fetch_assoc()) {
                                echo '<div class="ticket1" id="'.$rowT['tic_id'].'">'
                                        .'<i class="fa fa-times-circle delete closebtn" onclick="deleteTicket($(this).closest(\'div\').prop(\'id\'));" aria-hidden="true"></i>'
                                        .'<div class="ticket-borderTop"> </div>'
                                        .'<div class="ticket-div-content">'
                                            .'<div class="ticket-cont_main">'                              
                                                .'<div class="ticket-eventCatName" style="color: grey">'
                                                    .'<div class="ticketName">'
                                                        .'<span id = "lticketName'.$c.'">Ticket Title - </span>'
                                                        .'<input type = "text" title = "Enter Ticket Name" name = "" id = "ticketName'.$c.'" onkeyup = "insertData(this.value,this.id,'.$rowT['tic_id'].');" value = "'.checkValue($rowT['tic_name'],'').'"  onclick = "change(this.id,\'drop\');" onfocus = "change(this.id,\'drop\');" placeholder = "Enter Ticket Name" onblur = "labelHide(this.id,\'drop\');">'
                                                    .'</div>'
                                                    .'<div class="clear"></div>'
                                                    .'<div class="ticket-tckdesc" >'
                                                        .'<span id = "lticketDescription'.$c.'">Ticket Description - </span>'
                                                        .'<input type = "text" title = "Enter Description for Ticket" name = "" id = "ticketDescription'.$c.'" onkeyup = "insertData(this.value,this.id,'.$rowT['tic_id'].');" value = "'.checkValue($rowT['tic_description'],'').'" placeholder= "Enter Ticket description"   onclick = "change(this.id,\'drop\');" onfocus = "change(this.id,\'drop\');"  onblur = "labelHide(this.id,\'drop\');">'             
                                                    .'</div>'
                                                    .'<div  class="ticket-lastdate" >'   
                                                     // id = "lticketStart_date'.$c.'"                     
                                                        .'<span  class= "ticSpan">Available from - </span>'
                                                        .'<input  class= "ticDate" title = "Enter Last date for Tickets" type="text" id="ticketStart_date'.$c.'" placeholder="Tickets Available from..." onclick="getDate(this.id);" onfocus="getDate(this.id);" style="" onchange = "insertData(this.value,this.id,'.$rowT['tic_id'].');" value = "'.checkValue(date('dS M, Y',strtotime($rowT['tic_start_date'])),'date').'" placeholder="Tickets Available from" onclick = "change(this.id,\'drop\');" onfocus = "change(this.id,\'drop\');" onblur = "labelHide(this.id,\'drop\');">'  
                                                        .'<span class= "ticSpan">Available Till - </span>'
                                                        .'<input class = "ticDate" title = "Enter Last date for Tickets" type="text" id="ticketLast_date'.$c.'" placeholder="Tickets Available till..." onclick="getDate(this.id);" onfocus="getDate(this.id);" style="" onchange = "insertData(this.value,this.id,'.$rowT['tic_id'].');" value = "'.checkValue(date('dS M, Y',strtotime($rowT['tic_last_date'])),'date').'" placeholder="Tickets Available from" onclick = "change(this.id,\'drop\');" onfocus = "change(this.id,\'drop\');" onblur = "labelHide(this.id,\'drop\');">'
                                                    .'</div>'
                                                .'</div>'
                                                .'<div class="ticket-eventCatValue">'
                                                    .'<span id = "lticketPrice'.$c.'">Ticket Price - </span>'
                                                    .'<input type = "text" title = "Enter Price for Ticket" style = "text-align:center;width: 100%" name = "" id = "ticketPrice'.$c.'" onkeyup = "insertData(this.value,this.id,'.$rowT['tic_id'].');" value = "'.checkValue($rowT['tic_price'],'').'"  onclick = "change(this.id,\'blind\');" onfocus = "change(this.id,\'blind\');" placeholder = "Enter Price"  onblur = "labelHide(this.id,\'blind\');">'
                                                .'</div>'                                                     
                                                .'<div class="ticket-eventCatSelect">'
                                                    .'<div>'
                                                        .'<span id = "lticketTotal'.$c.'">Total Tickets - </span>'
                                                        .'<input type = "text" title = "Enter Total Available Tickets to be Sold" id="ticketTotal'.$c.'"  class="tquantity" onkeyup = "insertData(this.value,this.id,'.$rowT['tic_id'].');" value = "'.checkValue($rowT['tic_total'],'').'" onfocus = "change(this.id,\'blind\');" onclick = "change(this.id,\'blind\');" placeholder = "Total Tickets"  onblur = "labelHide(this.id,\'blind\');">'
                                                    .'</div>'
                                                    .'<div >'
                                                        .'<span id = "lticketMax'.$c.'">Max Tickets - </span>'
                                                        .'<input type="text" title = "Enter Max Allowed Tickets to be Purchased by Customer at a Time"  class="tquantity" id="ticketMax'.$c.'" onkeyup = "insertData(this.value,this.id,'.$rowT['tic_id'].');" value = "'.checkValue($rowT['tic_max'],'').'" onfocus = "change(this.id,\'blind\');" onclick = "change(this.id,\'blind\');" placeholder = "Max Tickets allow to book"  onblur = "labelHide(this.id,\'blind\');">'
                                                    .'</div>'
                                                .'</div>'
                                            .'</div>'
                                        .'</div>'                  
                                        .'<div class="clear"></div>'                
                                        .'<div class="ticket-borderBottom"></div>'                
                                    .'</div>';
                                    $c++;
                            }
                        } 
                        ?>
                        </div>
                        <div id = "ticketsCol" style="display: none;"></div>
                        <input type="hidden" id="totalTickets" value="<?php echo $c; ?>">
                        <button id = "addTicket" class="btn addMore"> <i class="fa fa-plus-circle"  title = "Click here to Add more Tickets" aria-hidden="true"></i> Add More Ticket</button>                    
                        <div class="clear"></div>
                        
                        <h3 class="event-h3">Event Terms & Conditions</h3> 
                        <div class = "term">
                            <div id="terms"></div>                        
                        </div> 
                    </div>
                </div><!-- /content -->
            </div>
            <!--newwwwwwww events end-->
        </div>
        <!-- Event Details Section -->
       <div class="advertise2" id = "details">
            <!-- <span class="edit3" id=""> </span> -->
            <div class="clear"></div>
            <div class="RightHeading">Event Details </div>
            <div id="RightSectionInfo">
                <i class="fa fa-list" aria-hidden="true"></i>
                <div  class="CalenderIcon">
                    <span id = ""  class="event-type">Event Type : </span>
                    <select class="event-select"  title = "Select Which Type of Event is These." name = "category" id = "eventCategory" onchange="getInputData($(this).attr('name'),this.id,'');">
                        <option value="-1">-Select-</option>
                        <?php 
                            $rowCat = getCategories($con);
                            foreach ($rowCat as $key => $val){
                                if($rowCat[$key]['cat_id'] === $row['category']){                                    
                                    echo '<option selected value="'.$rowCat[$key]['cat_id'].'">'.$rowCat[$key]['cat_name'].' </option>';
                                }else{
                                    echo '<option value="'.$rowCat[$key]['cat_id'].'">'.$rowCat[$key]['cat_name'].' </option>';

                                }
                            }
                        ?>
                    </select>        
                </div>
            </div>
            <div class="clear"></div>
            <div id="RightSectionInfo">
                <i class="fa fa-calendar" aria-hidden="true"></i>     
                <div  class="CalenderIcon">
                    <span id = "leventDate" class="event-type">Event Date : </span>
                    <input type = "text" class = "mydate"  title = "Select Start Date of Event" id= "eventFrom" name = "start_date" onchange = "getInputData($(this).attr('name'),this.id,'');" placeholder = "From"  onclick = "change(this.id,'blind');" value = "<?php echo $row['start_date'] == '' ? date('d M, Y',strtotime($date)) : date('d M, Y',strtotime(checkValue($row['start_date'],''))); ?>">
                    - <input type = "text" class = "mydate"  title = "Select End Date of Event" id= "eventTo" name = "end_date" onchange = "getInputData($(this).attr('name'),this.id,'');" placeholder = "To"  onclick = "change(this.id,'blind');" onblur = "labelHide(this.id,'blind');" value = "<?php echo $row['end_date'] == '' ? date('d M, Y',strtotime($date)) :  date('d M, Y',strtotime(checkValue($row['end_date'],''))); ?>">                
                </div>                
            </div>
            <div class="clear"></div>
            <div id="RightSectionInfo">            
                <i class="fa fa-clock-o" aria-hidden="true"></i>  
                <div class="TimeIcon">
                    <span id = "leventDate" class="event-type">Event Time : </span>
                    <input type="hidden" id = "evTime1" value = "<?php echo $row['start_date'] == '' ? date('h : i A',strtotime($date)) : date('h : i A',strtotime(checkValue($row['start_date'],''))); ?>">
                    <input type="hidden" id = "evTime2" value = "<?php echo $row['end_date'] == '' ? date('h : i A',strtotime($date)) : date('h : i A',strtotime(checkValue($row['end_date'],''))); ?>">
                    <input type = "text"  class = "mytime" title = "Select Start Time of Event" class= "timepicker" name = "start_date" id="eventTime1" onchange = "getInputData($(this).attr('name'),this.id,'');"  >
                    - <input type = "text" class = "mytime" title = "Select End Time of Event"  class= "timepicker" name = "end_date" id="eventTime2" onchange = "getInputData($(this).attr('name'),this.id,'');">                
                </div>
            </div>
            <div class="clear"></div>
            <div id="RightSectionInfo">
                <i class="fa fa-globe" aria-hidden="true"></i>  
                <div class="AddressIcon" >
                    <span id = "leventAddress" style="display: block;">Event Address :</span>
                    <div id="eventAddress" contenteditable="true"  title = "Address where Event is Happening" name = "address" class="event-add style-4" onblur = "blurDiv(this.id,'blind');" onclick="change(this.id,'blind');" onkeyup = "getDivData($(this).attr('name'),this.id,'');"><?php echo $row['address'] === '' || $row['address'] === '<br>'? 'Event Address' : $row['address']; ?></div>                
                </div>
            </div>
            <div class="clear"></div>
            <div id="RightSectionInfo">
                <i class="fa fa-map-pin" aria-hidden="true"></i>  
                <div class="AddressIcon" >
                    <?php 
                        $city = $row['event_city_id'] != '' ? $row['event_city_id'] : '2763';                    
                        $qry = "select * from cities inner join states on states.state_id = cities.city_state_id inner join countries on countries.country_id = states.state_country_id where cities.city_id = ".$city;

                        $resCity = $con->query($qry); 
                        if($resCity){
                            
                            $rowCity = $resCity->fetch_assoc();
                        }
                    ?>
                    <span id = "leventAddress" style="display: block;">Event City :</span>
                    <div class="citySelection">
                        <input type="hidden" name="city" id = "hiddenCity1" value="<?php echo $row['event_city_id']?>" >
                        <input type="text" autocomplete="off" class="login-btn-new" id = "selectCity1" onclick="selectCities('1')" placeholder="e.g. Pune, Mumbai" aria-describedby="basic-addon1"  title = "Add where Event is going to be." value="<?php echo $rowCity['city_name'].', '.$rowCity['state_name'].' - '.$rowCity['country_name'] ?>" >
                        <div class="scrollbar2 style-4" style="display: none;" id = "showCity1">
                            <div class="my-searchlist">
                                <ul id = "listCities1">
                                    <div id="back_result1">
                                    </div>
                                </ul>
                                <div class="force-overflow"></div>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="clear"></div>
                        <div id = "addCity1" style="display: none;">
                            <div class="col-md-4">
                                <select class="form-control" id = "country1" onchange="statesData('1',this.value);">
                                    <option value="-1">--Country--</option>
                                    <?php   
                                        $rCo = $con->query("select * from countries");
                                        while($rowCo = $rCo->fetch_assoc()){
                                            echo '<option value = "'.$rowCo["country_id"].'">'.$rowCo["country_name"].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-control" disabled="disabled" onchange="cityName('1');" id="states1">
                                    <option value="-1">--State--</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input class="login-btn-new" type="text" name="cityname" id="cityname1" disabled="disabled" onkeyup="checkCity('1',this.value);">
                            </div>
                            <div class="col-md-2">
                                <div class="add3" id = "addCityBtn1" style="display: none;" onclick="addCities('1');" ><i id = "btnIcon1" class="fa fa-plus-circle" aria-hidden="true"></i> Add</div>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="clear"></div>
            
            <div class="RightHeading">Contact Details</div>
            
            <div id="RightSectionInfo">
                <i class="fa fa-envelope-o" aria-hidden="true"></i> 
                <div class="AddressIcon">
                    <span id = "leventEmail" class="eventemail">Email - </span>
                    <div id="eventEmail" contenteditable="true" title = "Add Email Id of Event Organiser"  name = "email" class="event-email style-4" onblur = "blurDiv(this.id,'blind');" onclick="change(this.id,'blind');" onkeyup = "getDivData($(this).attr('name'),this.id,'');"><?php echo $row['email'] === '' || $row['email'] === '<br>'? 'Organiser Email ID' : $row['email']; ?></div> 
                </div>
            </div>
            <div class="clear"></div>            
            <div class="RightHeading">Social Share</div>
            <div id="RightSectionInfo" style="text-align:left;">
                <i class="fa fa-facebook" aria-hidden="true"></i> 
                <div class="social">
                    <div contenteditable="true" class="social6" id = "eventFacebook" title = "Add Facebook Link of Event" name = "e_fb_link" onblur = "blurDiv(this.id,'blind');" onclick="change(this.id,'blind');" onkeyup = "getDivData($(this).attr('name'),this.id,'');"><?php echo $row['e_fb_link'] === '' || $row['e_fb_link'] === '<br>' || $row['e_fb_link'] === NULL? 'Enter Facebook Link...' : $row['e_fb_link']; ?></div>                
                </div>
                <i class="fa fa-twitter mytwit" aria-hidden="true"></i> 
                <div class="social">
                    <div contenteditable="true" class="social6" title = "Add Twitter Link of Event" id = "eventTwitter" name = "e_twitter_link" onblur = "blurDiv(this.id,'blind');" onclick="change(this.id,'blind');" onkeyup = "getDivData($(this).attr('name'),this.id,'');"><?php echo $row['e_fb_link'] === '' || $row['e_twitter_link'] === '<br>' || $row['e_twitter_link'] === NULL? 'Enter Twitter Link...' : $row['e_twitter_link']; ?></div>                
                </div>
            </div>
        </div>      
        <div class="clearfix"></div>
    </div>
</div>
<div class="event-save" id = "publishData">
    <div id = "pubMsg"></div>
    <button id="publishBtn" class="btn save"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Publish Event</button>
</div>

<?php 
include 'instructions.php';
$script = '<script type="text/javascript" src = "js/create.js" ></script>'
    .'<script type="text/javascript" src = "js/instructions.js" ></script>';
include'footer.php';?>