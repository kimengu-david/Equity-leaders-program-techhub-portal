export default class Gate {
    constructor(user) {
        this.user = user;
    }
    isAdmin() {
        return this.user.role === "admin";
    }
    isUser() {
        return this.user.role === "user";
    }
    isTreasurer() {
        return this.user.role === "treasurer";
    }
    isMediaController() {
        return this.user.role === "mediacontroller";
    }
    isProjectLead() {
        return this.user.role === "projectlead";
    }
    isSecreatary() {
        return this.user.role === "secreatary";
    }
}
