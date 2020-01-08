let pop_modal = () => {
    document.getElementById('closed').id = 'overlay';
    document.getElementById('closed').id = 'modal';
};
let push_modal = () => {
    document.getElementById('overlay').id = 'closed';
    document.getElementById('modal').id = 'closed';
};
let pop_attendence = () => {
    document.getElementById('A_closed').id = 'attendence_overlay';
    document.getElementById('A_closed').id = 'attendence_modal';
};
let push_attendence = () => {
    document.getElementById('attendence_overlay').id = 'A_closed';
    document.getElementById('attendence_modal').id = 'A_closed';
};