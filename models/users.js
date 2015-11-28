Schema = {};

Schema.UserProfile = new SimpleSchema ({
balance: {
    type: Number,
    decimal: true,
    defaultValue: 0
}
});

Schema.User = new SimpleSchema({
    username: {
        type: String,
        regEx: /^[a-z0-9A-Z_]{3,15}$/,
        optional: true
    },
    emails: {
        type: [Object],
        optional: true
    },
    "emails.$.address": {
        type: String,
        regEx: /.*@denison\.edu/
    },
    "emails.$.verified": {
        type: Boolean
    },
    admin : {
        type: Number,
        defaultValue: 0
    },
    createdAt: {
        type: Date
    },
    services: {
        type: Object,
        optional: true,
        blackbox: true
    },
    profile: {
        type: Schema.UserProfile
    }
});

Meteor.users.attachSchema(Schema.User);

// Deny updates to all user fields
if (Meteor.isServer) {
  Meteor.users.deny({
    update: function () {
      return true;
    }
  });
}
