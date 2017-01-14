 var count = $("#count").val();
        for(var i=0;i<=count;i++)
        {                 
          new DG.OnOffSwitch({                            
            el: '#on-off-switch'+i,
            textOn: 'Published',
            textOff: 'UnPublished',
            listener:function(name, checked){              
              $.ajax({
                url:"ajax/organizerView.php",
                data:{tog:checked,nm:name},
                type: "POST",
                cache:true, 
                success : function(data){
                  console.log(data);
                }
              });              
            }    
          });
        } 