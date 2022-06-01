INSERT INTO symfony.stations (id, country_code, city) VALUES (1, 'DE', 'Dusseldorf');
INSERT INTO symfony.stations (id, country_code, city) VALUES (2, 'DE', 'Berlin');
INSERT INTO symfony.stations (id, country_code, city) VALUES (3, 'DE', 'Munich');
INSERT INTO symfony.stations (id, country_code, city) VALUES (4, 'AU', 'Graz');
INSERT INTO symfony.stations (id, country_code, city) VALUES (5, 'AU', 'Vienna');
INSERT INTO symfony.stations (id, country_code, city) VALUES (6, 'BE', 'Brussels');

INSERT INTO symfony.equipments (id, title, price, one_time_payment) VALUES (1, 'Bicycle carrier on the tailgate (including a warning sign required for travel to Italy or Spain)', 400, 0);
INSERT INTO symfony.equipments (id, title, price, one_time_payment) VALUES (2, 'Two additional camping chairs', 2500, 1);
INSERT INTO symfony.equipments (id, title, price, one_time_payment) VALUES (3, 'Additional camping table', 2500, 1);
INSERT INTO symfony.equipments (id, title, price, one_time_payment) VALUES (4, 'Car Seat for Children', 300, 0);
INSERT INTO symfony.equipments (id, title, price, one_time_payment) VALUES (5, 'Rack on the roof (two-bar system for surfboards, boxes, etc.)', 3500, 1);
INSERT INTO symfony.equipments (id, title, price, one_time_payment) VALUES (6, 'Portable camping toilet', 3500, 1);
INSERT INTO symfony.equipments (id, title, price, one_time_payment) VALUES (7, 'Bed linen 1 person (pillow, sheet, blanket)', 2900, 1);

INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (1, 1, 1, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (2, 1, 2, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (3, 1, 3, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (4, 1, 4, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (5, 1, 5, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (6, 1, 6, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (7, 1, 7, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (8, 2, 1, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (9, 2, 2, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (10, 2, 3, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (11, 2, 4, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (12, 2, 5, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (13, 2, 6, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (14, 2, 7, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (15, 3, 1, 8);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (16, 3, 2, 8);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (17, 3, 3, 8);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (18, 3, 4, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (19, 3, 5, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (20, 3, 6, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (21, 3, 7, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (22, 4, 1, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (23, 4, 2, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (24, 4, 3, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (25, 4, 4, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (26, 4, 5, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (27, 4, 6, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (28, 4, 7, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (29, 5, 1, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (30, 5, 2, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (31, 5, 3, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (32, 5, 4, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (33, 5, 5, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (34, 5, 6, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (35, 5, 7, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (36, 6, 1, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (37, 6, 2, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (38, 6, 3, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (39, 6, 4, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (40, 6, 5, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (41, 6, 6, 10);
INSERT INTO symfony.location_equipment (id, location_id, equipment_id, quantity) VALUES (42, 6, 7, 10);

INSERT INTO symfony.orders (id, start_location_id, end_location_id, camper_id, start_date, end_date, order_status) VALUES (1, 3, 4, null, '2022-05-30', '2022-05-31', 'new');
INSERT INTO symfony.orders (id, start_location_id, end_location_id, camper_id, start_date, end_date, order_status) VALUES (2, 3, 4, null, '2022-05-30', '2022-05-31', 'new');

INSERT INTO symfony.order_equipment (id, equipment_id, orders_id, ordered_equipment_qty) VALUES (1, 1, 1, 2);
INSERT INTO symfony.order_equipment (id, equipment_id, orders_id, ordered_equipment_qty) VALUES (2, 2, 1, 2);
INSERT INTO symfony.order_equipment (id, equipment_id, orders_id, ordered_equipment_qty) VALUES (3, 3, 1, 2);
INSERT INTO symfony.order_equipment (id, equipment_id, orders_id, ordered_equipment_qty) VALUES (4, 1, 2, 2);
INSERT INTO symfony.order_equipment (id, equipment_id, orders_id, ordered_equipment_qty) VALUES (5, 2, 2, 2);
INSERT INTO symfony.order_equipment (id, equipment_id, orders_id, ordered_equipment_qty) VALUES (6, 3, 2, 2);