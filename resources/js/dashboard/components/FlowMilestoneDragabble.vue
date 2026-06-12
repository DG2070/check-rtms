<template>
    <div>
        <div class="mt-4">
            <h4><strong>Milestones For FY 20{{ fiscal_year }}: </strong></h4>

            <!-- loading  -->
            <div class="loading" v-if="isuploading">
                <div class="row justify-content-center mt-4">
                    <div class="col-2">
                        <div class="spinner-border" role="status" style="width: 100px; height: 100px; color: green">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="set-target-dragable-table table-responsive" v-if="!isuploading">
                <table class="table table-bordered">
                    <thead class="thead-blue">
                        <tr>
                            <th class="text-center" v-if="!is_locked">Order</th>
                            <th>Activity</th>
                            <th class="text-nowrap">Milestone</th>
                            <th>Performance Indicator</th>
                            <th>Timeline Subjective</th>
                            <th v-if="!is_locked">Action</th>
                        </tr>
                    </thead>
                    <tbody is="draggable" :list="milestones" tag="tbody" handle=".handle">
                        <tr v-for="(item, index) in milestones" :key="item.milestone_id">
                            <td class="handle text-center" v-if="!is_locked">
                                <!-- <i class="fa fa-arrows-up-down-left-right " style="font-size:20px"></i> -->
                                {{ index + 1 }}
                            </td>
                            <td>
                                <select v-model="item.activity_id" class="form-control" :disabled="item.edit == 1">
                                    <option selected disabled>-- Select Activity --</option>
                                    <option v-for="item in activities" :key="item.activity_id" :value="item.activity_id">
                                        {{ item.activity_name }}
                                    </option>
                                </select>
                            </td>
                            <td>
                                <input v-model="item.milestone_name" type="text" class="form-control"
                                    placeholder="Enter Milestone" list="milestone_datalist" :disabled="item.edit == 1" />
                            </td>
                            <td>
                                <input v-model="item.performance_indicator" type="text" class="form-control"
                                    placeholder="Enter Performance Indicator" list="performance_indicator_datalist"
                                    :disabled="item.edit == 1" />
                            </td>
                            <td>
                                <select v-model="item.milestone_is_text" class="form-control" :disabled="item.edit == 1">
                                    <option selected disabled>-- Select --</option>
                                    <option value="no">no</option>
                                    <option value="yes">yes</option>
                                </select>
                            </td>

                            <td v-if="!is_locked">
                                <div class="text-center">
                                    <button class="btn btn-dark delete-milestone tdf-border-small"
                                        @click="enableEditMilestoneAt(index, item)">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button class="btn btn-danger delete-milestone tdf-border-small"
                                        @click="removeMilestoneAt(index, item)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- Milestone data list -->
                <datalist id="milestone_datalist">
                    <option v-for="name in milestone_datalist" :key="name">
                        {{ name }}
                    </option>
                </datalist>
                <datalist id="performance_indicator_datalist">
                    <option v-for="name in performance_indicator_datalist" :key="name">
                        {{ name }}
                    </option>
                </datalist>

                <div class="text-right my-2" v-if="!is_locked">
                    <button type="button" class="btn btn-primary btn-tdf-primary tdf-border-small" @click="addNewMilestone">
                        Add New Milestone For FY 20{{ fiscal_year }}
                    </button>
                    <button type="button" class="btn btn-primary btn-tdf-primary tdf-border-small"
                        @click="uploadNewMilestone">
                        Update Milestones For FY 20{{ fiscal_year }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import draggable from "vuedraggable";
import axios from "axios";

export default {
    props: [
        "fiscal_year",
        "project_id",
        "milestones_data",
        "activities_data",
        "old_milestones_name",
        "old_performance_indicator_name",
        "is_locked",
    ],
    data() {
        return {
            milestones: this.milestones_data,
            activities: this.activities_data,
            milestone_datalist: this.old_milestones_name,
            performance_indicator_datalist: this.old_performance_indicator_name,
            isuploading: false,
            removed_milestone_ids: [],
        };
    },
    components: {
        draggable,
    },
    methods: {
        enableEditMilestoneAt: function (index, item) {
            this.milestones[index].edit = 0;
        },
        removeMilestoneAt: function (index, item) {
            if (item.milestone_id > 0) {
                this.removed_milestone_ids.push(item.milestone_id);
            }
            this.milestones.splice(index, 1);
        },
        addNewMilestone: function () {
            if (this.activities.length > 0) {
                this.milestones.push({
                    activity_id: this.activities[0].activity_id,
                    milestone_name: "",
                    milestone_id: 0,
                    milestone_is_text: "no",
                    performance_indicator: "",
                });
            }
        },
        uploadNewMilestone: function () {
            var self = this;
            self.isuploading = true;
            var formdata = new FormData();
            formdata.append("milestones", JSON.stringify(self.milestones));
            formdata.append(
                "removed_milestone_ids",
                JSON.stringify(self.removed_milestone_ids)
            );
            // console.log(self.milestones);
            // var
            axios
                .post(
                    "/api/set-target/" + self.project_id + "/upload-milestones",
                    formdata
                )
                .then(function (response) {
                    // handle success
                    console.log("response");
                    console.log(response);

                    self.$toast.open({
                        message: "Updated successfully",
                        type: "success",
                        duration: 5000,
                        dismissible: true,
                        position: "top-right",
                    });
                    location.reload();
                })
                .catch(function (error) {
                    // handle error
                    console.log("error");
                    console.log(error);
                    self.$toast.open({
                        message: "Something went wrong ! try again ",
                        type: "danger",
                        duration: 5000,
                        dismissible: true,
                        position: "top-right",
                    });
                })
                .finally(function () {
                    // always executed
                    self.isuploading = false;
                });
        },
    },
    mounted() {
        // console.log(this.milestones);
        // this.milestones_data.map((element, index) => {
        //     element.milestone_order = index + 1
        //     var newelement = element
        //     this.milestones.push(
        //         newelement
        //     )
        // })
        // console.log(this.milestones);
        // console.log(this.activities);
        // console.log(this.project_id);
    },
};
</script></script>
