<template>
  <section class="content">
    <alert :dismissible="true"></alert>
    <button
      type="button"
      class="inline-block px-8 py-4 bg-blue-600 text-white font-black text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
      data-bs-toggle="modal" data-bs-target="#exampleModalLabel"
      @click="clickModal()"
    >Create Permission</button>

    <!-- Modal -->
    <div
      class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
      id="exampleModalLabel"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable relative w-auto pointer-events-none" role="document">
        <div class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
          <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
            <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel" v-if="editMode">Update Permission</h5>
            <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel" v-else>Create Permission</h5>

            <button type="button" class="close"    data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body relative p-4">
            <form @submit.prevent="save">
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Name:</label>
                <input
                  type="text"
                  class="form-control h-8 px-3 w-full border-gray-200 border rounded focus:outline-none focus:border-gray-300  "
                  :class="errors.name ? 'border-red-500' :''"
                  v-model="form.name"
                  id="recipient-name"
                />
                <div class="text-red-500" v-if="errors.name">{{ errors.name }}</div>
              </div>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Permissions:</label>
                <Multiselect
                  v-model="form.permission"
                  mode="tags"
                  :appendNewTag="false"
                  :createTag="false"
                  :searchable="true"
                  label="name"
                  valueProp="id"
                  trackBy="name"
                  :options="permissions"
                  class="form-control"
                
                />
              </div>
              <div class="text-red-500" v-if="errors.permission">{{ errors.permission }}</div>
              <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                <button
                  type="button"
                  class="inline-block px-6 py-2.5 bg-gray-200 text-gray-700 font-black text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-300 hover:shadow-lg focus:bg-gray-300 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-400 active:shadow-lg transition duration-150 ease-in-out"
                  data-bs-dismiss="modal"
                >Close</button>
                <button
                  @click.prevent="save()"
                  type="submit"
                  class="inline-block px-6 py-2.5 bg-gray-800 text-white font-black text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-900 hover:shadow-lg focus:bg-gray-900 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-900 active:shadow-lg transition duration-150 ease-in-out"
                >Save changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="flex flex-col mt-6">
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
          <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
            <table class="w-full text-xs text-left text-gray-500 dark:text-gray-400">
              <thead class="bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-back text-gray-500 uppercase tracking-wider"
                  >id</th>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-back text-gray-500 uppercase tracking-wider"
                  >name</th>
                  <th
                    scope="col"
                    class="px-6 py-3 text-left text-xs font-back text-gray-500 uppercase tracking-wider"
                  >Permissions</th>
                  <th scope="col" class="relative px-6 py-3">
                    <span class="sr-only">Edit</span>
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:border-gray-700 text-white">
                <tr v-for="role in  roles.data" :key="role.id">
                  <td class="px-6 py-4 whitespace-nowrap dark:text-white">
                    <div class="flex items-center">
                      <div class="ml-4">
                        <div class="text-xs font-medium text-gray-900 dark:text-white">{{ role.id }}</div>
                      </div>
                    </div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap dark:text-white">
                    <div class="text-xs text-gray-900 dark:text-white">{{ role.name }}</div>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap dark:text-white">
                    <span
                      v-for="permission in role.permissions"
                      :key="permission.id"
                      class="bg-gray-600 text-gray-100 text-xs px-2 mx-1 py-1 rounded"
                    >{{ permission.name }}</span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium ">
                    <button
                    data-bs-toggle="modal" data-bs-target="#exampleModalLabel"
                      class="inline-block px-6 py-2.5 bg-gray-200 text-gray-700 font-black text-xs leading-tight uppercase rounded shadow-md hover:bg-gray-300 hover:shadow-lg focus:bg-gray-300 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-400 active:shadow-lg transition duration-150 ease-in-out"
                      @click="edit(role)"
                    >Update</button>
                    <button
                      @click="deleteRow(role.id)"
                      class="inline-block px-6 py-2.5 bg-red-800 text-white font-black text-xs leading-tight uppercase rounded shadow-md hover:bg-red-900 hover:shadow-lg focus:bg-red-900 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-900 active:shadow-lg transition duration-150 ease-in-out"
                    >Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
            <pagination class="mt-6" :links="roles.links" />
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue";
import LayoutForum from "@/Pages/Forum/Layout";

import Pagination from "@/Components/Pagination";
import Alert from "@/Components/Alert";
import Multiselect from "@vueform/multiselect/dist/multiselect.vue2.js";
import admin from "./mixins/admin";
export default {
  layout: LayoutForum,
  mixins: [admin],
  components: {
    Link,
    Pagination,
    Alert,
    Multiselect
  },
  props: {
    permissions: Array,
    roles: Object,
    errors: Object
  },
  data() {
    return {
      editMode: false,
      showModal: false,
      form: this.$inertia.form({
        id: null,
        name: null,
        permission: null
      })
    };
  },
  methods: {
    save() {
      if (this.editMode) {
        this.form.put(route("admin.roles.update", this.form.id), {
          preserveState: true,
          onError: errors => {
            if (Object.keys(errors).length > 0) {
              this.editMode = true;
            }
          },
          onSuccess: page => {
            $("#exampleModalLabel").modal("hide");
            this.reset();
          }
        });
      } else {
        this.form.post(route("admin.roles.store"), {
          preserveState: true,
          onError: errors => {
            if (Object.keys(errors).length > 0) {
              this.editMode = false;
            }
          },
          onSuccess: page => {
            $("#exampleModalLabel").modal("hide");
            this.reset();
          }
        });
      }
    },
    reset: function() {
      this.form = this.$inertia.form({
        id: null,
        name: null,
        permission: null
      });
    },

    clickModal() {
      this.editMode = false;
      this.reset();
    },
    edit(data) {
      this.editMode = true;
      this.form.id = data.id;
      this.form.name = data.name;
      // let object = Object.assign({}, data.permissions);
      // console.log(typeof object);
      // // // // let first = Object.assign({}, object[0]);
      // let array = [];
      // $.each(object, function(key, value) {
      //   array.push(parseInt(value.id));
      // });
      //trả về một biến array chưa id của permission
      // this.form = Object.assign({}, data);
      this.form.permission = this.multipleSelect(data.permissions);
      this.editMode = true;
    },
    deleteRow(id) {
      if (!confirm("Are you sure want to remove?")) return;
      this.$inertia.delete(route("admin.roles.delete", id));
    }
  }
};
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<style>
.multiselect-tags-search {
  font-size: 1.25rem;
}
</style>