function createIssue(ticketId, dropdown) {
    let dropdownProject = document.getElementById('dropdown_project' + dropdown);
    let selectedProject = dropdownProject.options[dropdownProject.selectedIndex].value;

    console.log(selectedProject);

    jQuery.ajax({
        type: "POST",
        url: "../plugins/gitlabintegration/ajax/issue.php",
        data: {
            selectedProject: selectedProject,
            ticketId: ticketId
        }
    })
        .fail(function () {
            return false;
        });
}

function myFunction(dropdown, selectedProject) {
    let dropdownProject = document.getElementById('dropdown_project' + dropdown);
    console.log("Projeto Default: " + selectedProject + " - Projeto Inicial: " + dropdownProject.options[dropdownProject.selectedIndex].value);

    for (var i, j = 0; i = dropdownProject.options[j]; j++) {
        if (i.value == selectedProject) {
            dropdownProject.selectedIndex = j;
            break;
        }
    }

    console.log("Projeto Default Banco: " + selectedProject + " - Projeto Default Final: " + dropdownProject.options[dropdownProject.selectedIndex].value);

    let span = document.getElementById('select2-dropdown_project' + dropdown + '-container');
    span.textContent = dropdownProject.options[dropdownProject.selectedIndex].text;

    console.log("Novo Span: " + dropdownProject.options[dropdownProject.selectedIndex].text);
}
