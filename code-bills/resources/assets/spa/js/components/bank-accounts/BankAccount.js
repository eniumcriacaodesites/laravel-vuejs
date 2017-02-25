class BankAccount {
    constructor(data = {}) {
        this.name = '';
        this.agency = '';
        this.account = '';
        this.bank_id = '';

        Object.assign(this, data);
    }

    toJSON() {
        return {
            name: this.name,
            agency: this.agency,
            account: this.account,
            bank_id: this.bank_id,
        }
    }
}

export default BankAccount;
