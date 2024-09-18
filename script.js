const addBox = document.querySelector(".add-box"),
popupBox = document.querySelector(".popup-box"),
popupTitle = popupBox.querySelector("header p"),
closeIcon = popupBox.querySelector("header i"),
titleTag = popupBox.querySelector("input"),
descTag = popupBox.querySelector("textarea"),
addBtn = popupBox.querySelector("button");

const months = ["January", "February", "March", "April", "May", "June", "July",
"August", "September", "October", "November", "December"];
let notes = JSON.parse(localStorage.getItem("notes") || "[]");
let isUpdate = false, updateId;

addBox.addEventListener("click", () => {
popupTitle.innerText = "Add a new Note";
addBtn.innerText = "Add Note";
popupBox.classList.add("show");
document.querySelector("body").style.overflow = "hidden";
if (window.innerWidth > 660) titleTag.focus();
});

closeIcon.addEventListener("click", () => {
isUpdate = false;
titleTag.value = descTag.value = "";
popupBox.classList.remove("show");
document.querySelector("body").style.overflow = "auto";
});

function showNotes() {
if (!notes) return;
document.querySelectorAll(".note").forEach(li => li.remove());
notes.forEach((note, id) => {
    let filterDesc = note.description.replaceAll("\n", '<br/>');
    let liTag = `<li class="note">
            <div class="details">
                <p>${note.title}</p>
                <span>${filterDesc}</span>
            </div>
            <div class="bottom-content">
                <span>${note.date}</span>
                <div class="settings">
                    <i onclick="showMenu(this)" class="uil uil-ellipsis-h"></i>
                    <ul class="menu">
                        <li onclick="updateNote(${id}, '${note.title}', '${filterDesc}')"><i class="uil uil-pen"></i>Edit</li>
                        <li onclick="deleteNote(${id})"><i class="uil uil-trash-alt"></i>Delete</li>
                        <li onclick="toggleFavorite(${id})"><i class="uil uil-heart"></i>Favorite</li>
                    </ul>
                </div>
            </div>
        </li>`;
    document.querySelector(".notes-container").innerHTML += liTag;
});
}
showNotes();

function updateNote(id, title, desc) {
isUpdate = true;
updateId = id;
popupTitle.innerText = "Update the Note";
addBtn.innerText = "Update";
titleTag.value = title;
descTag.value = desc.replaceAll('<br/>', '\n');
popupBox.classList.add("show");
document.querySelector("body").style.overflow = "hidden";
titleTag.focus();
}

function deleteNote(id) {
notes.splice(id, 1);
localStorage.setItem("notes", JSON.stringify(notes));
showNotes();
}

function toggleFavorite(id) {
notes[id].favorite = !notes[id].favorite;
localStorage.setItem("notes", JSON.stringify(notes));
showNotes();
}

function searchNotes() {
let searchText = document.getElementById("searchInput").value.toLowerCase();
let searchedNotes = notes.filter(note => note.title.toLowerCase().includes(searchText) || note.description.toLowerCase().includes(searchText));
notes = searchedNotes;
showNotes();
}

function showMenu(ele) {
ele.parentElement.classList.toggle("show");
}

function formatDate() {
let today = new Date();
let month = months[today.getMonth()].slice(0, 3);
let date = today.getDate();
let year = today.getFullYear();
return `${month} ${date}, ${year}`;
}

addBtn.addEventListener("click", () => {
let title = titleTag.value;
let desc = descTag.value;
let date = formatDate();
if (!title || !desc) return;
if (isUpdate) {
    notes[updateId] = { title, description: desc, date, favorite: false };
} else {
    notes.unshift({ title, description: desc, date, favorite: false });
}
localStorage.setItem("notes", JSON.stringify(notes));
titleTag.value = descTag.value = "";
popupBox.classList.remove("show");
document.querySelector("body").style.overflow = "auto";
isUpdate = false;
updateId = null;
showNotes();
});