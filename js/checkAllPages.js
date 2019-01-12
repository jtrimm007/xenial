function selectall(ele)
{
    var selectAll = document.getElementsByName("checkCon");
    var checkboxes = document.getElementsByName("pages[]");

    if(ele.checked)
    {
        for(var i = 0; i < checkboxes.length; i++)
        {
            if(checkboxes[i].type == "checkbox")
            {
                checkboxes[i].checked = true;
            }

            checkboxes[i].check = ele.checked;
        }
    }
    else
    {
        for ( var i = 0; i < checkboxes.length; i++)
        {
            if ( checkboxes[i].type == "checkbox")
            {
                checkboxes[i].checked = false;
            }
        }
    }
}


