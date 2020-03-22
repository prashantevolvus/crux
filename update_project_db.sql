use project_management;

update project_details set cr_amt = 0 where project_details.status not in ('DELETED','CLOSED');

update project_details set cr_amt = 
(select sum(cr_amount) from project_cr 
where project_cr.status = 'ACCEPTED' and id = project_id
group by `Project_id`)
where exists 
(select sum(cr_amount) from project_cr 
where project_cr.status = 'ACCEPTED' and id = project_id
group by `Project_id`) and project_details.status not in ('DELETED','CLOSED');


update project_details set invoice_pending_lcy_amt = 0 where project_details.status not in ('DELETED','CLOSED');

update project_details set invoice_pending_lcy_amt = 
(select sum(lcy_amount) from project_invoice
where project_invoice.status = 'PENDING' and id = project_id
group by `Project_id`)
where exists 
(select 1 from project_invoice 
where project_invoice.status = 'PENDING' and id = project_id
group by `Project_id`)  and project_details.status not in ('DELETED','CLOSED');

update project_details set invoiced_lcy_amt = 0 where project_details.status not in ('DELETED','CLOSED');

update project_details set invoiced_lcy_amt = 
(select sum(lcy_amount) from project_invoice
where project_invoice.status = 'INVOICED' and id = project_id
group by `Project_id`)
where exists 
(select 1 from project_invoice 
where project_invoice.status = 'INVOICED' and id = project_id
group by `Project_id`)  and project_details.status not in ('DELETED','CLOSED');

update project_details set received_lcy_amt = 0 where project_details.status not in ('DELETED','CLOSED');

update project_details set received_lcy_amt = 
(select sum(lcy_cr_amount) from project_invoice
where project_invoice.status = 'PAID' and id = project_id
group by `Project_id`)
where exists 
(select 1 from project_invoice 
where project_invoice.status = 'PAID' and id = project_id
group by `Project_id`)  and project_details.status not in ('DELETED','CLOSED');

update project_details set budget_approved = 0 where project_details.status not in ('DELETED','CLOSED');


update project_details set budget_approved = 
(select sum(excess_budget) from project_excess_budget
where project_excess_budget.status = 'AUTHORISED' and category <> 'OVERRUN' and project_details.id = project_id
group by `Project_id`)
where exists 
(select 1 from project_excess_budget 
where project_excess_budget.status = 'AUTHORISED' and category <> 'OVERRUN' and project_details.id = project_id
group by `Project_id`)  and project_details.status not in ('DELETED','CLOSED');

update project_details set budget_initiated = 0 where project_details.status not in ('DELETED','CLOSED');


update project_details set budget_initiated = 
(select sum(excess_budget) from project_excess_budget
where project_excess_budget.status = 'INITIATED' and category <> 'OVERRUN' and project_details.id = project_id
group by `Project_id`)
where exists 
(select 1 from project_excess_budget 
where project_excess_budget.status = 'INITIATED' and category <> 'OVERRUN' and project_details.id = project_id
group by `Project_id`)  and project_details.status not in ('DELETED','CLOSED');

update project_details set excess_budget_approved = 0 where project_details.status not in ('DELETED','CLOSED');


update project_details set excess_budget_approved = 
(select sum(excess_budget) from project_excess_budget
where project_excess_budget.status = 'AUTHORISED' and category  = 'OVERRUN' and project_details.id = project_id
group by `Project_id`)
where exists 
(select 1 from project_excess_budget 
where project_excess_budget.status = 'AUTHORISED' and category = 'OVERRUN' and project_details.id = project_id
group by `Project_id`)  and project_details.status not in ('DELETED','CLOSED');

update project_details set excess_budget_initiated = 0 where project_details.status not in ('DELETED','CLOSED');


update project_details set excess_budget_initiated = 
(select sum(excess_budget) from project_excess_budget
where project_excess_budget.status = 'INITIATED' and category = 'OVERRUN' and project_details.id = project_id
group by `Project_id`)
where exists 
(select 1 from project_excess_budget 
where project_excess_budget.status = 'INITIATED' and category = 'OVERRUN' and project_details.id = project_id
group by `Project_id`)  and project_details.status not in ('DELETED','CLOSED');


update project_details set expense_amt   =  0 where  project_details.status not in ('DELETED','CLOSED');

update project_details set expense_amt   = 
(select expense_cost from project_summary
where  ohrm_project_id = project_id
)
where exists 
(select 1 from project_summary
where  ohrm_project_id = project_id
)  and project_details.status not in ('DELETED','CLOSED');

update project_details set base_labour_cost   =  0 where  project_details.status not in ('DELETED','CLOSED');


update project_details set base_labour_cost  = 
(select base_labour_cost  from project_summary
where ohrm_project_id = project_id
)
where exists 
(select 1 from project_summary
where ohrm_project_id = project_id
) and project_details.status not in ('DELETED','CLOSED');

update project_details set unified_labour_cost   =  0 where  project_details.status not in ('DELETED','CLOSED');

update project_details set unified_labour_cost  = 
(select unitLabourCost from project_summary
where ohrm_project_id = project_id
)
where exists 
(select 1 from project_summary
where  ohrm_project_id = project_id
) and project_details.status not in ('DELETED','CLOSED');

