document.addEventListener("DOMContentLoaded", function () {
  const userForm = document.getElementById("userForm");
  const userList = document.getElementById("userList");
  const userIdField = document.getElementById("userId");
  const errorMessageField = document.getElementById("errorMessage");

  function fetchUsers() {
    fetch("http://localhost/index.php?url=user")
      .then(async (response) => {
        if (response.ok) {
          return response.json();
        }
        const error = await response.json();
        alert(error.message);
      })
      .then((data) => {
        if (data?.users) {
          userForm.querySelector('button[type="submit"]').textContent = "Ajouter";
          userList.innerHTML = "";
          data.users.forEach((user) => {
            const li = document.createElement("li");
            li.innerHTML = `<span id="${user.name}">${user.name} (${user.email})</span>
                      <button onclick="editUser(${user.id}, '${user.name}', '${user.email}')">✏️</button>
                      <button onclick="deleteUser(${user.id})">❌</button>`;
            userList.appendChild(li);
          });
        }
      });
  }

  userForm.addEventListener("submit", function (e) {
    e.preventDefault();
    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const userId = userIdField.value;

    if (userId) {
      fetch("http://localhost/index.php?url=user", {
        method: "PUT",
        body: new URLSearchParams({ id: userId, name, email }),
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
      })
        .then(async (response) => {
          if (response.ok) {
            return response.json();
          }

          const error = await response.json();
          if (errorMessageField) {
            errorMessageField.textContent = error.message;
          }
        })
        .then(() => {
          fetchUsers();
          userForm.reset();
          userIdField.value = "";
        });
    } else {
      fetch("http://localhost/index.php?url=user", {
        method: "POST",
        body: new URLSearchParams({ name, email }),
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
      })
        .then(async (response) => {
          if (response.ok) {
            return response.json();
          }

          const error = await response.json();
          if (errorMessageField) {
            errorMessageField.textContent = error.message;
          }
        })
        .then(() => {
          fetchUsers();
          userForm.reset();
        });
    }
  });

  window.editUser = function (id, name, email) {
    document.getElementById("name").value = name;
    document.getElementById("email").value = email;
    userForm.querySelector('button[type="submit"]').textContent = "Update";
    userIdField.value = id;
  };

  window.deleteUser = function (id) {
    fetch(`http://localhost/index.php?url=user&&id=${id}`, {
      method: "DELETE",
    }).then(() => fetchUsers());
  };

  fetchUsers();
});
