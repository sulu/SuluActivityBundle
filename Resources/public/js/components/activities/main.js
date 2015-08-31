/*
 * This file is part of the Sulu CMS.
 *
 * (c) MASSIVE ART WebServices GmbH
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

define([
        'text!suluactivity/components/activities/activity.form.html',
        'widget-groups',
        'suluactivity/model/activity',
        'config',
        'sulucontact/model/contact',
        'sulucontact/model/account'
    ],
    function(ActivityForm, WidgetGroups, Activity, Config, Contact, Account) {

        'use strict';

        var constants = {
                overlayId: 'activitiesOverlay',
                activityListSelector: '#activities-list',
                activityFormSelector: '#acitivity-form',

                activitiesURL: '/admin/api/activities/'
            },

            /**
             * Template for header toolbar
             * @returns {*[]}
             */
            listTemplate = function() {
                return [
                    {
                        id: 'add',
                        icon: 'plus-circle',
                        class: 'highlight-white',
                        title: 'add',
                        position: 10,
                        callback: this.addOrEditActivity.bind(this)
                    },
                    {
                        id: 'settings',
                        icon: 'gear',
                        items: [
                            {
                                id: 'delete',
                                title: this.sandbox.translate('contact.activities.remove'),
                                callback: function() {
                                    this.sandbox.emit('husky.datagrid.items.get-selected',
                                        function(ids) {
                                            if (ids.length > 0) {
                                                this.removeActivities(ids);
                                            }
                                        }.bind(this));
                                }.bind(this),
                                disabled: true
                            }
                        ]
                    }
                ];
            };

        return {

            view: true,

            layout: function() {
                return {
                    content: {
                        width: 'fixed'
                    },
                    sidebar: {
                        width: 'max',
                        cssClasses: 'sidebar-padding-50'
                    }
                };
            },

            templates: ['/admin/activity/template/contact/activities'],

            initialize: function() {
                this.getSystemMembers().then(function() {
                    this.initTypeDependentVariables(this.options.type);
                    this.dfdEntityLoaded = this.sandbox.data.deferred();
                    this.loadEntity();

                    this.sandbox.dom.when(this.dfdEntityLoaded).then(function() {
                        this.bindCustomEvents();
                        this.render();

                        if (WidgetGroups.exists(this.options.widgetGroup)) {
                            this.initSidebar(this.options.widgetGroup, this.options.id);
                        }
                    }.bind(this));
                }.bind(this));
            },

            /**
             * Loads the entity according to the given type and id
             */
            loadEntity: function() {
                this.entity.fetch({
                    success: function(model) {
                        this.model = model.toJSON();
                        this.dfdEntityLoaded.resolve();
                    }.bind(this),
                    error: function() {
                        this.sandbox.logger.log('error while fetching ' + this.options.type);
                        this.dfdEntityLoaded.reject();
                    }.bind(this)
                });
            },

            /**
             * Initializes the type dependend variables
             *
             * @param type
             */
            initTypeDependentVariables: function(type) {
                switch (type) {
                    case 'contact':
                        this.breadcrumb = Config.get('sulucontact.breadcrumb.contact');
                        this.entity = new Contact({id: this.options.id});
                        this.routeToList = Config.get('sulucontact.routeToList.contact');
                        break;
                    case 'account':
                        this.breadcrumb = Config.get('sulucontact.breadcrumb.account');
                        this.entity = new Account({id: this.options.id});
                        this.routeToList = Config.get('sulucontact.routeToList.account');
                        break;
                }
            },

            /**
             * loads system members
             */
            getSystemMembers: function() {
                return this.sandbox.util.load('api/contacts?bySystem=true')
                    .then(function(response) {
                        this.responsiblePersons = response._embedded.contacts;
                    }.bind(this))
                    .fail(function(textStatus, error) {
                        this.sandbox.logger.error(textStatus, error);
                    }.bind(this));
            },

            initSidebar: function(widgetGroup, id) {
                this.sandbox.emit('sulu.sidebar.set-widget', '/admin/widget-groups/' + widgetGroup + '?' + this.options.type + '=' + id);
            },

            bindCustomEvents: function() {
                // listen for defaults for types/statuses/prios
                this.sandbox.once('sulu_activity.activities.set-defaults',
                    function(defaults) {
                        var el, sub;
                        for (el in defaults) {
                            if (defaults.hasOwnProperty(el)) {
                                for (sub in defaults[el]) {
                                    if (defaults[el].hasOwnProperty(sub)) {
                                        defaults[el][sub].translation = this.sandbox.translate(defaults[el][sub].name);
                                    }
                                }
                            }
                        }
                        this.activityDefaults = defaults;
                    }, this);

                // edit activity
                this.sandbox.on('husky.datagrid.item.click', function(id) {
                    this.loadActivity(id);
                }, this);

                // back to list
                this.sandbox.on('sulu.header.back', function() {
                    this.sandbox.emit('sulu.router.navigate', this.routeToList);
                }, this);

                // set data in overlay
                this.sandbox.on('husky.overlay.activity-add-edit.opened', function() {
                    // start components in overlay
                    this.sandbox.start(constants.activityFormSelector);
                    var formObject = this.sandbox.form.create(constants.activityFormSelector);

                    formObject.initialized.then(function() {
                        this.sandbox.form.setData(constants.activityFormSelector, this.overlayData);
                    }.bind(this));
                }.bind(this));

                this.sandbox.dom.on('husky.datagrid.number.selections', function(number) {
                    if (number > 0) {
                        this.sandbox.emit('husky.toolbar.activities.item.enable', 'delete');
                    } else {
                        this.sandbox.emit('husky.toolbar.activities.item.disable', 'delete');
                    }
                }.bind(this));
            },

            loadActivity: function(id) {
                if (!!id) {
                    this.activity = Activity.findOrCreate({id: id});
                    this.activity.fetch({
                        success: function(model) {
                            this.activity = model;
                            this.startOverlay(model.toJSON());
                        }.bind(this),
                        error: function(e1, e2) {
                            this.sandbox.logger.log('error while fetching activity', e1, e2);
                        }.bind(this)
                    });
                } else {
                    this.sandbox.logger.warn('no id given to load activity');
                }
            },

            /**
             * Sets the title to the contact name
             * default title as fallback
             */
            setTitle: function() {
                var title = this.sandbox.translate('contact.contacts.title'),
                    breadcrumb = this.breadcrumb;

                if (!!this.options.id) {
                    switch (this.options.type) {
                        case 'contact':
                            title = this.model.fullName;
                            break;
                        case 'account':
                            title = this.model.name;
                            break;
                    }
                    breadcrumb.push({title: '#' + this.options.id});
                }

                this.sandbox.emit('sulu.header.set-title', title);
                this.sandbox.emit('sulu.header.set-breadcrumb', breadcrumb);
            },

            /**
             * Inits the process to add or edit an activity
             */
            addOrEditActivity: function(id) {
                if (!!id) {
                    this.loadActivity(id)
                } else {
                    this.startOverlay(null);
                }
            },

            /**
             * starts overlay to edit / add activity
             */
            startOverlay: function(data) {
                var translation, activityTemplate, $container, values;

                this.sandbox.dom.remove('#' + constants.overlayId);
                $container = this.sandbox.dom.createElement('<div id="' + constants.overlayId + '"></div>');
                this.sandbox.dom.append(constants.activityListSelector, $container);

                this.overlayData = data;

                if (!!data && !!data.id) {
                    translation = this.sandbox.translate('contact.contacts.activities.edit');
                } else {
                    translation = this.sandbox.translate('contact.contacts.activities.add');
                }

                values = {
                    activityType: !!data && !!data.activityType ? data.activityType.id : '',
                    activityStatus: !!data && !!data.activityStatus ? data.activityStatus.id : '',
                    activityPriority: !!data && !!data.activityPriority ? data.activityPriority.id : '',
                    assignedContact: !!data && !!data.assignedContact ? data.assignedContact.id : '',
                    activityTypes: this.activityDefaults.activityTypes,
                    activityPriorities: this.activityDefaults.activityPriorities,
                    activityStatuses: this.activityDefaults.activityStatuses,
                    responsiblePersons: this.responsiblePersons,
                    translate: this.sandbox.translate
                };

                activityTemplate = this.sandbox.util.template(ActivityForm, values);

                this.sandbox.start([
                    {
                        name: 'overlay@husky',
                        options: {
                            el: $container,
                            title: translation,
                            openOnStart: true,
                            removeOnClose: true,
                            instanceName: 'activity-add-edit',
                            data: activityTemplate,
                            skin: 'wide',
                            okCallback: this.editAddOkClicked.bind(this),
                            closeCallback: this.stopOverlayComponents.bind(this)
                        }
                    }
                ]);
            },

            /**
             * Stops subcomponents of overlay
             */
            stopOverlayComponents: function() {
                this.sandbox.stop(constants.activityFormSelector);
            },

            /**
             * triggered when overlay was closed with ok
             */
            editAddOkClicked: function() {
                if (this.sandbox.form.validate(constants.activityFormSelector, true)) {
                    var data = this.sandbox.form.getData(constants.activityFormSelector);

                    if (!!this.isContact() && !data.contact) {
                        data.contact = {id: this.options.id};
                    }

                    if (!!this.isAccount() && !data.account) {
                        data.account = {id: this.options.id};
                    }

                    if (!data.id) {
                        delete data.id;
                    }

                    this.save(data);
                    this.stopOverlayComponents();
                } else {
                    return false;
                }
            },

            save: function(data) {
                var isNew = true;
                if (!!data.id) {
                    isNew = false;
                }

                this.activity = Activity.findOrCreate({id: data.id});
                this.activity.set(data);
                this.activity.save(null, {
                    // on success save contacts id
                    success: function(response) {
                        this.activity = this.flattenActivityObjects(response.toJSON());
                        this.activity.assignedContact = this.activity.assignedContact.fullName;

                        if (!!isNew) {
                            this.sandbox.emit('husky.datagrid.record.add', this.activity);
                        } else {
                            this.sandbox.emit('husky.datagrid.records.change', this.activity);
                        }

                    }.bind(this),
                    error: function() {
                        this.sandbox.logger.log("error while saving activity");
                    }.bind(this)
                });
            },

            /**
             * Flattens type/status/priority
             * @param activity
             */
            flattenActivityObjects: function(activity) {
                if (!!activity.activityStatus) {
                    activity.activityStatus = this.sandbox.translate(activity.activityStatus.name);
                }
                if (!!activity.activityType) {
                    activity.activityType = this.sandbox.translate(activity.activityType.name);
                }
                if (!!activity.activityPriority) {
                    activity.activityPriority = this.sandbox.translate(activity.activityPriority.name);
                }

                return activity;
            },

            render: function() {
                var url;
                this.sandbox.dom.html(
                    this.$el,
                    this.renderTemplate('/admin/activity/template/contact/activities'
                    ));

                this.setTitle();
                url = '/admin/api/activities?sortBy=dueDate&sortOrder=asc&flat=true&' + this.options.type + '=' + this.options.id;

                // init list-toolbar and datagrid
                this.sandbox.sulu.initListToolbarAndList.call(
                    this,
                    'activitiesContactsFields',
                    '/admin/api/activities/fields',
                    {
                        el: this.$find('#list-toolbar-container'),
                        instanceName: 'activities',
                        inHeader: true,
                        template: listTemplate.call(this)
                    },
                    {
                        el: this.sandbox.dom.find('#activities-list', this.$el),
                        url: url,
                        searchInstanceName: 'activities',
                        searchFields: ['subject'],
                        resultKey: 'activities',
                        viewOptions: {
                            table: {
                                selectItem: {
                                    type: 'checkbox'
                                },
                                removeRow: false
                            }
                        }
                    }
                );
            },

            /**
             * Removes elements from datagrid
             */
            removeActivities: function(ids) {
                this.confirmDeleteDialog(function(wasConfirmed) {
                    if (wasConfirmed) {
                        var activity;
                        this.sandbox.util.foreach(ids, function(id) {
                            activity = Activity.findOrCreate({id: id});
                            activity.destroy({
                                success: function() {
                                    this.sandbox.emit('husky.datagrid.record.remove', id);
                                }.bind(this),
                                error: function() {
                                    this.sandbox.logger.log("error while deleting activity");
                                }.bind(this)
                            });
                        }.bind(this));
                    }
                }.bind(this));
            },

            isAccount: function() {
                return this.options.type === 'account';
            },

            isContact: function() {
                return this.options.type === 'contact';
            },

            /**
             * @var ids - array of ids to delete
             * @var callback - callback function returns true or false if data got deleted
             */
            confirmDeleteDialog: function(callbackFunction) {
                // check if callback is a function
                if (!!callbackFunction && typeof(callbackFunction) !== 'function') {
                    throw 'callback is not a function';
                }

                // show warning dialog
                this.sandbox.emit('sulu.overlay.show-warning',
                    'sulu.overlay.be-careful',
                    'sulu.overlay.delete-desc',

                    function() {
                        // cancel callback
                        callbackFunction(false);
                    }.bind(this),

                    function() {
                        // ok callback
                        callbackFunction(true);
                    }.bind(this)
                );
            }
        };
    });
