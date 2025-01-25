async function editComment(commentId) {
    try {
        window.location.href = `/admin/comments/${commentId}/edit`;
    } catch (error) {
        console.error("Error editing comment:", error);
    }
}

async function toggleCommentStatus(commentId, newStatus) {
    console.log("Comment function hit ID:", commentId);
    try {

        const response = await axios.post(`/admin/comments/${commentId}/status`, { status: newStatus });

        console.log("Status updated:", response.data);


        const statusElement = document.getElementById(`status-${commentId}`);

        if (statusElement) {

            statusElement.textContent = response.data.status;
            location.reload();

        }
        console.log("Comment hit try ID:", commentId);
    } catch (error) {
        console.error("Error toggling status:", error);
    }
}




async function deleteComment(commentId) {
   

    Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const response = await axios.delete(`/admin/comments/${commentId}`);
                // Update the UI based on response
                console.log("Comment deleted:", response.data);
                location.reload();
            } catch (error) {
                console.error("Error deleting comment:", error);
            }
        }

    });

}
