USE talabat;

ALTER TABLE restaurants
    CHANGE COLUMN image logo VARCHAR(255),
    ADD COLUMN banner VARCHAR(255) AFTER logo;