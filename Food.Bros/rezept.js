document.getElementById("commentForm").addEventListener("submit", function(event) {
    event.preventDefault();
  
    const commentInput = document.getElementById("commentInput");
    const commentText = commentInput.value.trim();
  
    if (commentText !== "") {
      const commentList = document.getElementById("commentList");
      const newComment = document.createElement("li");
      newComment.textContent = commentText;
      commentList.appendChild(newComment);
  
      // Clear the comment input field
      commentInput.value = "";
    }
});
  