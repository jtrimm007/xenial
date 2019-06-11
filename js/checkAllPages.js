function selectAllPages(pages)
{
    var selectAll = document.getElementsByName("checkCon");
    var checkboxes = document.getElementsByName("pages[]");

    if(pages.checked)
    {
        for(var i = 0; i < checkboxes.length; i++)
        {
            if(checkboxes[i].type == "checkbox")
            {
                checkboxes[i].checked = true;
            }

            checkboxes[i].check = pages.checked;
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


