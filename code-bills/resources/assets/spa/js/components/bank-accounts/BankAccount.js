class BankAccount {
    constructor(data = {}) {
        this.name = '';
        this.agency = '';
        this.account = '';
        this.bank_id = '';
        this.default = false;

        Object.assign(this, data);
    }

    toJSON() {
        return {
            name: this.name,
            agency: this.agency,
            account: this.account,
            bank_id: this.bank_id,
            default: this.default,
        }
    }
}

export default BankAccount;
