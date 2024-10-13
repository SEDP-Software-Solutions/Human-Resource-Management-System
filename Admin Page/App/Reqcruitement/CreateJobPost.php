<!-- Create Job Post Modal -->
<div class="modal fade" id="CreateJobPost" tabindex="-1" aria-labelledby="createJobPostLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createJobPostLabel">Create Job Offer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../Controller/JobOfferController.php?action=create" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="jobId" class="form-label">Job Title</label>
                            <select class="form-select" name="jobId" id="jobId" required onchange="updateFields(this)">
                                <option value="" disabled selected>Select Job Title</option>
                                <?php foreach ($jobSelects as $job): ?>
                                    <option value="<?= $job['jobId'] ?>"
                                        data-id="<?= htmlspecialchars($job['jobId']) ?>"
                                        data-description="<?= htmlspecialchars($job['description']) ?>"
                                        data-qualification="<?= htmlspecialchars($job['qualification']) ?>"
                                        data-min-salary="<?= htmlspecialchars($job['minimumSalary']) ?>"
                                        data-max-salary="<?= htmlspecialchars($job['maximumSalary']) ?>">
                                        <?= htmlspecialchars($job['title']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="JobDescription" class="form-label">Job Description</label>
                            <textarea class="form-control" name="JobDescription" id="JobDescription" rows="3" required></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="qualification" class="form-label">Qualification</label>
                            <input type="text" class="form-control" name="qualification" id="qualification" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="department<?= $row['jobOfferId'] ?>" class="form-label">Department Name</label>
                            <select class="form-select" name="departmentName" id="department<?= $row['jobOfferId'] ?>" required onchange="updateDepartmentDetails(this)">

                                <option value="" disabled selected>Select Department</option>
                                <?php foreach ($departmentSelects as $department): ?>
                                    <option value="<?= $department['DepartmentName'] ?>"
                                        data-id="<?= $department['departmentId'] ?>"
                                        data-location="<?= $department['BranchLocation'] ?>"
                                        <?= $department['DepartmentName'] == $row['DepartmentName'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($department['DepartmentName']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <input type="hidden" name="departmentId" id="departmentId">

                        <div class="col-md-6 mb-3">
                            <label for="min_salary" class="form-label">Minimum Salary</label>
                            <input type="number" class="form-control" name="min_salary" id="min_salary" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="location<?= $row['jobOfferId'] ?>" class="form-label">Location</label>
                            <input type="text" class="form-control" name="location" id="location<?= $row['jobOfferId'] ?>" value="<?= htmlspecialchars($row['location']) ?>" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="max_salary" class="form-label">Maximum Salary</label>
                            <input type="number" class="form-control" name="max_salary" id="max_salary" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="EmployeeType" class="form-label">Employee Type</label>
                            <select class="form-select" name="EmployeeType" id="EmployeeType" required>
                                <option value="" disabled>Select Employee Type</option>
                                <option value="Full-time">Full-time</option>
                                <option value="Part-time">Part-time</option>
                                <option value="Contract">Contract</option>
                                <option value="Intern">Intern</option>
                                <option value="Freelance">Freelance</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Job Offer</button>
                </div>
            </form>
        </div>
    </div>
</div>