function createIssue(ticketId, dropdown, selectedProject) {
    let dropdownProject = document.getElementById('dropdown_project' + dropdown);
    let newSelectedProject = dropdownProject.options[dropdownProject.selectedIndex].value;

    creatAgain = true;

    if (selectedProject == newSelectedProject) {
        creatAgain = confirm('Issue already created for the selected project. Do you want creat it again?')
    }

    if (creatAgain) {
        jQuery.ajax({
            type: "POST",
            url: "../plugins/gitlabintegration/ajax/issue.php",
            data: {
                selectedProject: newSelectedProject,
                ticketId: ticketId
            }
        })
            .success(function () {
                location.reload();
            })
            .fail(function () {
                return false;
            });
    }
}

function setSelectedProject(dropdown, selectedProject) {
    let dropdownProject = document.getElementById('dropdown_project' + dropdown);

    if (selectedProject) {
        for (var i, j = 0; i = dropdownProject.options[j]; j++) {
            if (i.value == selectedProject) {
                dropdownProject.selectedIndex = j;
                break;
            }
        }
        let span = document.getElementById('select2-dropdown_project' + dropdown + '-container');
        span.textContent = dropdownProject.options[dropdownProject.selectedIndex].text;
    }
}
