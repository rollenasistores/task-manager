<?php
include 'config/constants.php';
include 'config/db-connections.php';
include 'functions.php';
include 'config/header.php';
?>

<script>

document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    
      themeSystem: 'bootstrap5',
      expandRows: true,
      slotMinTime: '08:00',
      slotMaxTime: '20:00',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      events: 'events.php'
  });
  calendar.render();
});

</script>

    <?php
    // Get the username from the URL
    $username = isset($_GET['username']) ? $_GET['username'] : null;

    // If the username is provided, fetch the corresponding user_id
    if ($username !== null) {
        $userId = getUserIdByUsername($conn, $username);


    } else {
        echo "Username not provided.";
    }
    ?>
    <!-- Tasks Starts Here -->
    <p>
        <?php
        displaySessionMessage('add');
        displaySessionMessage('delete');
        displaySessionMessage('update');
        displaySessionMessage('delete_fail');
        ?>
    </p>
    <?php             
                    if (isset($_SESSION['login_message'])) {
                    echo "
                    <div class='alert alert-success' role='alert'>
                    {$_SESSION['login_message']}
                    </div>";
                    unset($_SESSION['login_message']);
                    }
                    ?>

<?php             
                    if (isset($_SESSION['message'])) {
                    echo "
                    <div class='alert alert-danger' role='alert'>
                    {$_SESSION['message']}
                    </div>";
                    unset($_SESSION['message']);
                    }
                    ?>
                <div class="row">
                <div class="col-12 col-sm-6 col-xl-4 mb-4">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <div class="row d-block d-xl-flex align-items-center">
                                <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                    <div class="icon-shape icon-shape-danger rounded me-4 me-sm-0">
                                        <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                                    </div>
                                    <div class="d-sm-none">
                                        <h2 class="h5">To dos</h2>
                                        <h3 class="fw-extrabold mb-1"><?php displayCountonAllList($conn, $userId, $username, 1); ?></h3>
                                    </div>
                                </div>
                                <div class="col-12 col-xl-7 px-xl-0">
                                    <div class="d-none d-sm-block">
                                        <h2 class="h6 text-gray-400 mb-0">To dos</h2>
                                        <h3 class="fw-extrabold mb-2"><?php displayCountonAllList($conn, $userId, $username, 1); ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4 mb-4">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <div class="row d-block d-xl-flex align-items-center">
                                <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                    <div class="icon-shape icon-shape-info rounded me-4 me-sm-0">
                                        <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                                    </div>
                                    <div class="d-sm-none">
                                        <h2 class="h5">In Progress</h2>
                                        <h3 class="fw-extrabold mb-1"><?php displayCountonAllList($conn, $userId, $username, 2); ?></h3>
                                    </div>
                                </div>
                                <div class="col-12 col-xl-7 px-xl-0">
                                    <div class="d-none d-sm-block">
                                        <h2 class="h6 text-gray-400 mb-0">In Progress</h2>
                                        <h3 class="fw-extrabold mb-2"><?php displayCountonAllList($conn, $userId, $username, 2); ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-4 mb-4">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <div class="row d-block d-xl-flex align-items-center">
                                <div class="col-12 col-xl-5 text-xl-center mb-3 mb-xl-0 d-flex align-items-center justify-content-xl-center">
                                    <div class="icon-shape icon-shape-success rounded me-4 me-sm-0">
                                        <svg class="icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                                    </div>
                                    <div class="d-sm-none">
                                        <h2 class="h5">Completed</h2>
                                        <h3 class="fw-extrabold mb-1"><?php displayCountonAllList($conn, $userId, $username, 3); ?></h3>
                                    </div>
                                </div>
                                <div class="col-12 col-xl-7 px-xl-0">
                                    <div class="d-none d-sm-block">
                                        <h2 class="h6 text-gray-400 mb-0">Completed</h2>
                                        <h3 class="fw-extrabold mb-2"><?php displayCountonAllList($conn, $userId, $username, 3); ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <div class="card border-0 shadow">
                                <div class="card-header" >
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h2 class="fs-5 fw-bold mb-0">Task List</h2>
                                        </div>
                                        <div class="col text-end">
                                        <a href="<?=SITEURL?>add-task.php?username=<?=$username?>" class="btn btn-sm btn-success">Add new Task</a>
                                        </div>
                                    </div>
                                </div>
                                <div id='calendar' class="mx-4 mt-2 mb-4"></div>
</div>

<?php include 'config/footer.php'; ?>
</body>

</html>