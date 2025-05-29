<?php
/**
 * Query to get pending orders with customer details
 */
$order_customer = "
    SELECT 
        o.order_id,
        o.created_at,
        o.order_value,
        o.sp_discounts,
        o.order_status,
        o.notes as order_notes,
        c.cust_id,
        c.cust_name,
        c.mobile_1,
        c.mobile_2,
        c.address,
        a.area_name,
        a.governorate
    FROM s_orders o
    INNER JOIN s_customer c ON o.cust_id = c.cust_id
    INNER JOIN del_area a ON c.area = a.area_id
    WHERE o.order_status = 'Ordered'
    ORDER BY o.created_at DESC";

/**
 * Query to get order products with details
 */
$order_products = "
    SELECT 
        o.order_id,
        o.order_value,
        p.product_id,
        p.name_eng,
        p.name_ar,
        p.unit_price,
        op.qty,
        op.total,
        p.description_ar,
        p.start_date,
        p.end_date
    FROM s_orders o
    INNER JOIN j_order_product op ON o.order_id = op.order_id
    INNER JOIN s_product p ON op.product_id = p.product_id
    WHERE o.order_status = 'Ordered'
    ORDER BY o.order_id, p.product_id";

/**
 * Query to get order summary with totals
 */
$order_summary = "
    SELECT 
        o.order_id,
        COUNT(op.product_id) as total_products,
        SUM(op.qty) as total_items,
        o.order_value,
        o.sp_discounts,
        (o.order_value - o.sp_discounts) as final_amount,
        c.cust_name,
        a.area_name
    FROM s_orders o
    INNER JOIN s_customer c ON o.cust_id = c.cust_id
    INNER JOIN del_area a ON c.area = a.area_id
    LEFT JOIN j_order_product op ON o.order_id = op.order_id
    WHERE o.order_status = 'Ordered'
    GROUP BY o.order_id
    ORDER BY o.created_at DESC";

/**
 * Recommended indexes for performance
 */
$create_indexes = "
    CREATE INDEX IF NOT EXISTS idx_orders_status ON s_orders(order_status, created_at);
    CREATE INDEX IF NOT EXISTS idx_customer_area ON s_customer(area);
    CREATE INDEX IF NOT EXISTS idx_order_product ON j_order_product(order_id, product_id);
";
