function createIssue(ticketId, dropdown, selectedProject, ticketName, ticketContent) {
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
                ticketId: ticketId,
                ticketName: ticketName,
                ticketContent: ticketContent
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

function addProfile(dropdown, userId) {
    let dropdownProfile = document.getElementById('dropdown__profiles_id' + dropdown);
    let newProfileSelected = dropdownProfile.options[dropdownProfile.selectedIndex].value;

    jQuery.ajax({
        type: "POST",
        url: "../ajax/profile.php",
        data: {
            profileId: newProfileSelected,
            userId: userId
        }
    })
        .success(function () {
            console.log("Entrou");
            window.open("../front/profiles.php", "_self");
        })
        .fail(function () {
            return false;
        });
}

function setClickCheckAll(checkboxName, principal) {
    checkboxName = 'checkAll_' + checkboxName;
    let checkbox = document.getElementsByName(checkboxName);
    checkbox[0].addEventListener("click", function () {
        if (principal) {
            checkAllBoxes(checkboxName, checkbox[0].checked);
        } else {
            changeCheckAll();
        }
    }, false);
}

function checkAllBoxes(checkboxName, selected) {
    let inputs = document.getElementsByTagName("input");
    for (let i = 0; i < inputs.length; i++) {
        if (inputs[i].type == "checkbox") {
            if (inputs[i].name != checkboxName) {
                inputs[i].checked = selected;
            }
        }
    }
}

function changeCheckAll() {
    let inputsData = document.getElementById('data').getElementsByTagName('input');

    let i;
    let countSelected = 0;
    for (i = 0; i < inputsData.length; i++) {
        if (inputsData[i].type == "checkbox") {
            if (inputsData[i].checked) {
                countSelected++;
            }
        }
    }

    let inputTop = document.getElementById('principal_1').getElementsByTagName('input');
    let inputBotton = document.getElementById('principal_2').getElementsByTagName('input');

    if (countSelected == inputsData.length) {
        changeCheckInput(inputTop, true);
        changeCheckInput(inputBotton, true);
    } else {
        changeCheckInput(inputTop, false);
        changeCheckInput(inputBotton, false);
    }
}

function changeCheckInput(inputArray, checked) {
    for (i = 0; i < inputArray.length; i++) {
        if (inputArray[i].type == "checkbox") {
            inputArray[i].checked = checked;
        }
    }
}
