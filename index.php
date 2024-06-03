<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Table Row</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container-fluid mt-5">
        <h2 class="mb-4 text-center">Frontend</h2>
        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th colspan="2">Item</th>
                    <th scope="col">Person</th>
                    <th scope="col">Status</th>
                    <th colspan="2">
                        <div class="timeline d-flex justify-content-around">
                            <div class="time">
                                Timeline
                            </div>
                            <div class="dependency">
                                Dependency
                            </div>
                        </div>
                    </th>
                    <th scope="col">Tags</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody id="table-body">
                <tr>
                    <td>Verbal and Non-verbal</td>
                    <td><i class="bi bi-plus-square"></i></td>
                    <td>
                        <img src="https://via.placeholder.com/30" class="rounded-img" alt="Person 1">
                        <img src="https://via.placeholder.com/30" class="rounded-img" alt="Person 2" style="margin-left: -8%;">
                    </td>
                    <td class="status-done text-center">Success</td>
                    <td class="text-center">20 - 24 Mar</td>
                    <td><a href="#" class="dependency-link">Verbal and Non-verbal</a></td>
                    <td><span class="tag">CommunicationBasics</span></td>
                    <td><i class="bi bi-plus"></i></td>
                </tr>
                <tr id="add-more-row">
                    <td colspan="2"><a href="#" id="add-more"><i class="bi bi-plus"></i> Add Item </a></td>
                </tr>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#add-more').on('click', function(e) {
                e.preventDefault();
                var newRow = `
                <tr>
                    <td><input type="text" class="form-control" placeholder="Item"></td>
                    <td><i class="bi bi-plus-square"></i></td>
                    <td>
                        <img src="https://via.placeholder.com/30" class="rounded-img" alt="Person 1">
                        <img src="https://via.placeholder.com/30" class="rounded-img" alt="Person 2" style="margin-left: -8%;">
                    </td>
                    <td class="text-center"><input type="text" class="form-control" placeholder="Status"></td>
                    <td class="text-center">
                        <input type="date" class="form-control" placeholder="From Date">
                        <input type="date" class="form-control" placeholder="End Date">
                    </td>
                    <td><input type="text" class="form-control" placeholder="Dependency Slug"></td>
                    <td>
                        <div class="tag-container">
                            <input type="text" class="form-control tag-input" placeholder="Tag">
                            <button class="btn btn-secondary add-tag">Add Tag</button>
                        </div>
                    </td>
                    <td><button class="btn btn-primary save-row">Save</button></td>
                </tr>`;
                $('#add-more-row').before(newRow);
            });

            $(document).on('click', '.add-tag', function() {
                var tagInput = $(this).siblings('.tag-input');
                var tagValue = tagInput.val();
                if (tagValue) {
                    var newTag = `<span class="badge badge-primary">${tagValue}</span>`;
                    $(this).closest('.tag-container').prepend(newTag);
                    tagInput.val('');
                }
            });

            $(document).on('click', '.save-row', function() {
                var row = $(this).closest('tr');
                var item = row.find('input').eq(0).val();
                var status = row.find('input').eq(1).val();
                var fromDate = row.find('input').eq(2).val();
                var endDate = row.find('input').eq(3).val();
                var dependency = row.find('input').eq(4).val();
                var tags = row.find('.badge').map(function() {
                    return $(this).text();
                }).get().join(', ');

                var rowData = {
                    item: item,
                    status: status,
                    fromDate: fromDate,
                    endDate: endDate,
                    dependency: dependency,
                    tags: tags
                };

                localStorage.setItem('rowData', JSON.stringify(rowData));

                row.html(`
                    <td>${item}</td>
                    <td><i class="bi bi-plus-square"></i></td>
                    <td>
                        <img src="https://via.placeholder.com/30" class="rounded-img" alt="Person 1">
                        <img src="https://via.placeholder.com/30" class="rounded-img" alt="Person 2" style="margin-left: -8%;">
                    </td>
                    <td class="text-center">${status}</td>
                    <td class="text-center">${fromDate} - ${endDate}</td>
                    <td>${dependency}</td>
                    <td>${tags}</td>
                    <td><button class="btn btn-secondary edit-row">Edit</button></td>
                `);
            });

            $(document).on('click', '.edit-row', function() {
                var row = $(this).closest('tr');
                var item = row.find('td').eq(0).text();
                var status = row.find('td').eq(3).text();
                var timeline = row.find('td').eq(4).text().split(' - ');
                var fromDate = timeline[0];
                var endDate = timeline[1];
                var dependency = row.find('td').eq(5).text();
                var tags = row.find('td').eq(6).html();

                row.html(`
                    <td><input type="text" class="form-control" value="${item}"></td>
                    <td><i class="bi bi-plus-square"></i></td>
                    <td>
                        <img src="https://via.placeholder.com/30" class="rounded-img" alt="Person 1">
                        <img src="https://via.placeholder.com/30" class="rounded-img" alt="Person 2" style="margin-left: -8%;">
                    </td>
                    <td class="text-center"><input type="text" class="form-control" value="${status}"></td>
                    <td class="text-center">
                        <input type="date" class="form-control" value="${fromDate}">
                        <input type="date" class="form-control" value="${endDate}">
                    </td>
                    <td><input type="text" class="form-control" value="${dependency}"></td>
                    <td>
                        <div class="tag-container">
                            ${tags}
                            <input type="text" class="form-control tag-input" placeholder="Tag">
                            <button class="btn btn-secondary add-tag">Add Tag</button>
                        </div>
                    </td>
                    <td><button class="btn btn-primary save-row">Save</button></td>
                `);
            });
        });
    </script>
</body>

</html>