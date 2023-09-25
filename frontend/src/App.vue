<template>
  <v-app>
    <v-row>
      
      <v-col cols="12" class="pa-6">
        <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
            class="mb-5"
      >
      </v-text-field>
        <v-data-table
        :headers="headers"
        :items="desserts"
        :search="search"
        :options.sync="options"
        :server-items-length="totalDesserts"
        :loading="loading"
        :footer-props="{
          'items-per-page-options': [10,20,30,40,50,150]
        }"
        class="elevation-1"
      >
      <template v-slot:[`item.actions`]="{ item }">

            <v-tooltip top>
                <template v-slot:activator="{ on }">
                    <v-btn small text color="grey" v-on="on" router :to="`/dashboard/edit-agri-category/${item.id}`">
                        <v-icon left small>mdi-pencil</v-icon>
                        <span right class="caption text-lowercase">Edit</span>
                    </v-btn>
                </template>
                <span>Edit</span>
            </v-tooltip>

            <v-tooltip top>
                <template v-slot:activator="{ on }">
                    <v-btn small text color="grey" v-on="on" @click="deleteagricategory(item.id)">
                        <v-icon left small>mdi-delete</v-icon>
                        <span right class="caption text-lowercase">Delete</span>
                    </v-btn>
                </template>
                <span>Delete</span>
            </v-tooltip>

      </template>
      </v-data-table>
      </v-col>
    </v-row>
  </v-app>
</template>

<script>
import axios from "axios";

export default {
  name: 'App',

  data () {
      return {
        totalDesserts: 0,
        desserts: [],
        loading: true,
        options: {},
        search: '',
        headers: [
          { text: 'ID', value: 'id' },
          { text: 'Name', value: 'name' },
          { text: 'Email', value: 'email' },
          { text: 'Phone', value: 'phone' },
          {text: 'Actions', value: 'actions', align: 'center', sortable: false },
        ],
      }
    },
    watch: {
      options: {
        handler () {
          this.getDataFromApi()
        },
        deep: true,
      },

      search: {
        handler () {
          this.getDataFromApi()
        },
      },
    },
    methods: {
      getDataFromApi () {
        this.loading = true

        const { sortBy, sortDesc, page, itemsPerPage } = this.options
        
        axios.get('http://localhost:8000/api/users', {
          params: {
            sortBy: sortBy[0],
            sortDesc: sortDesc[0],
            page: page,
            itemsPerPage: itemsPerPage,
            search: this.search
          }
        }).then((result) => {
            this.desserts = result.data.data;
            this.totalDesserts = result.data.total;
            this.loading = false;
        }).catch((err) => {
          console.log(err);
        })
      },
    },

};
</script>
