<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240328002328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agent (id INT AUTO_INCREMENT NOT NULL, god_father_id INT DEFAULT NULL, grade_id INT DEFAULT NULL, department_id INT DEFAULT NULL, service_id INT DEFAULT NULL, job_id INT DEFAULT NULL, user_id INT DEFAULT NULL, profile_id INT DEFAULT NULL, province_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, last_name VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, register VARCHAR(255) NOT NULL, cart_number VARCHAR(255) DEFAULT NULL, pseudo VARCHAR(255) NOT NULL, sex VARCHAR(1) DEFAULT NULL, marital_status VARCHAR(8) DEFAULT NULL, born_at DATE DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) NOT NULL, origin VARCHAR(255) NOT NULL, father VARCHAR(255) DEFAULT NULL, mother VARCHAR(255) DEFAULT NULL, conjoint VARCHAR(255) DEFAULT NULL, children JSON DEFAULT NULL, blood VARCHAR(255) NOT NULL, level_of_studies VARCHAR(255) NOT NULL, god_father_num VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, conjoint_origin LONGTEXT DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, INDEX IDX_268B9C9D487CFC8E (god_father_id), INDEX IDX_268B9C9DFE19A1A8 (grade_id), INDEX IDX_268B9C9DAE80F5DF (department_id), INDEX IDX_268B9C9DED5CA9E6 (service_id), INDEX IDX_268B9C9DBE04EA9 (job_id), INDEX IDX_268B9C9DA76ED395 (user_id), UNIQUE INDEX UNIQ_268B9C9DCCFA12B8 (profile_id), INDEX IDX_268B9C9DE946114A (province_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assignment (id INT AUTO_INCREMENT NOT NULL, origin_id INT DEFAULT NULL, destination_id INT DEFAULT NULL, agent_id INT DEFAULT NULL, year_id INT DEFAULT NULL, province_id INT DEFAULT NULL, start_at DATE DEFAULT NULL, end_at DATE DEFAULT NULL, is_active TINYINT(1) NOT NULL, paths JSON DEFAULT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_30C544BA56A273CC (origin_id), INDEX IDX_30C544BA816C6140 (destination_id), INDEX IDX_30C544BA3414710B (agent_id), INDEX IDX_30C544BA40C1FEA7 (year_id), INDEX IDX_30C544BAE946114A (province_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE currency (id INT AUTO_INCREMENT NOT NULL, first JSON NOT NULL, last JSON NOT NULL, rate NUMERIC(10, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE department (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, paths JSON DEFAULT NULL, is_sub_dep TINYINT(1) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, INDEX IDX_CD1DE18A727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE department_service (id INT AUTO_INCREMENT NOT NULL, department_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, INDEX IDX_5C347231AE80F5DF (department_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doc_object (id INT AUTO_INCREMENT NOT NULL, file_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expense (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, year_id INT DEFAULT NULL, object VARCHAR(255) NOT NULL, bearer VARCHAR(255) NOT NULL, operations JSON NOT NULL, total NUMERIC(10, 6) NOT NULL, currency JSON NOT NULL, rate NUMERIC(10, 2) NOT NULL, released_at DATETIME DEFAULT NULL, INDEX IDX_2D3A8DA6A76ED395 (user_id), INDEX IDX_2D3A8DA640C1FEA7 (year_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expense_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_deleted TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE folder (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, doc_object_id INT DEFAULT NULL, agent_id INT DEFAULT NULL, INDEX IDX_ECA209CDC54C8C93 (type_id), UNIQUE INDEX UNIQ_ECA209CDDFF56A4A (doc_object_id), INDEX IDX_ECA209CD3414710B (agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE folder_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_deleted TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fuel (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, stock DOUBLE PRECISION DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fuel_site (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address LONGTEXT DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fuel_site_fuel (fuel_site_id INT NOT NULL, fuel_id INT NOT NULL, INDEX IDX_4C717653598164E0 (fuel_site_id), INDEX IDX_4C71765397C79677 (fuel_id), PRIMARY KEY(fuel_site_id, fuel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fuel_stock_supply (id INT AUTO_INCREMENT NOT NULL, fuel_id INT DEFAULT NULL, supply_id INT DEFAULT NULL, quantity DOUBLE PRECISION NOT NULL, INDEX IDX_2280F8E997C79677 (fuel_id), INDEX IDX_2280F8E9FF28C0D8 (supply_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fuel_supply (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grade (id INT AUTO_INCREMENT NOT NULL, department_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, INDEX IDX_595AAE34AE80F5DF (department_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image_object (id INT AUTO_INCREMENT NOT NULL, file_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE job (id INT AUTO_INCREMENT NOT NULL, service_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, INDEX IDX_FBD8E0F8ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medical (id INT AUTO_INCREMENT NOT NULL, year_id INT DEFAULT NULL, observation LONGTEXT DEFAULT NULL, INDEX IDX_77DB075A40C1FEA7 (year_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medical_file (id INT AUTO_INCREMENT NOT NULL, medical_id INT DEFAULT NULL, doc_object_id INT DEFAULT NULL, user_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_DF6C9C38592AF3BA (medical_id), INDEX IDX_DF6C9C38DFF56A4A (doc_object_id), INDEX IDX_DF6C9C38A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission (id INT AUTO_INCREMENT NOT NULL, roadmap_id INT DEFAULT NULL, exit_permit_id INT DEFAULT NULL, mission_order_id INT DEFAULT NULL, expense_id INT DEFAULT NULL, agent_id INT DEFAULT NULL, user_id INT DEFAULT NULL, year_id INT DEFAULT NULL, object VARCHAR(255) NOT NULL, place VARCHAR(255) NOT NULL, start_at DATE DEFAULT NULL, end_at DATE DEFAULT NULL, transport VARCHAR(255) NOT NULL, transport_name VARCHAR(255) DEFAULT NULL, ticket_number VARCHAR(255) DEFAULT NULL, accommodation VARCHAR(255) DEFAULT NULL, accommodation_address LONGTEXT DEFAULT NULL, observation LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_9067F23C135345B2 (roadmap_id), UNIQUE INDEX UNIQ_9067F23CC467131E (exit_permit_id), UNIQUE INDEX UNIQ_9067F23C85636C81 (mission_order_id), UNIQUE INDEX UNIQ_9067F23CF395DB7B (expense_id), INDEX IDX_9067F23C3414710B (agent_id), INDEX IDX_9067F23CA76ED395 (user_id), INDEX IDX_9067F23C40C1FEA7 (year_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mission_agent (mission_id INT NOT NULL, agent_id INT NOT NULL, INDEX IDX_B61DC3A0BE6CAE90 (mission_id), INDEX IDX_B61DC3A03414710B (agent_id), PRIMARY KEY(mission_id, agent_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, type_id INT DEFAULT NULL, province_id INT DEFAULT NULL, agent_id INT DEFAULT NULL, image_object_id INT DEFAULT NULL, postal_code VARCHAR(6) DEFAULT NULL, avenue VARCHAR(255) NOT NULL, number VARCHAR(255) NOT NULL, quarter VARCHAR(255) DEFAULT NULL, commune VARCHAR(255) DEFAULT NULL, surface VARCHAR(255) NOT NULL, pieces INT DEFAULT NULL, price NUMERIC(10, 6) DEFAULT NULL, description LONGTEXT DEFAULT NULL, status VARCHAR(255) NOT NULL, is_available TINYINT(1) DEFAULT NULL, longitude LONGTEXT DEFAULT NULL, latitude LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_8BF21CDEC54C8C93 (type_id), INDEX IDX_8BF21CDEE946114A (province_id), UNIQUE INDEX UNIQ_8BF21CDE3414710B (agent_id), UNIQUE INDEX UNIQ_8BF21CDEFBAF8D7F (image_object_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_deleted TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE province (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_4ADAD40B5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE refueling (id INT AUTO_INCREMENT NOT NULL, site_id INT DEFAULT NULL, fuel_id INT DEFAULT NULL, vehicle_id INT DEFAULT NULL, agent_id INT DEFAULT NULL, quantity DOUBLE PRECISION NOT NULL, created_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_5C524674F6BD1646 (site_id), UNIQUE INDEX UNIQ_5C52467497C79677 (fuel_id), UNIQUE INDEX UNIQ_5C524674545317D1 (vehicle_id), INDEX IDX_5C5246743414710B (agent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salary (id INT AUTO_INCREMENT NOT NULL, agent_id INT DEFAULT NULL, year_id INT DEFAULT NULL, base_amount NUMERIC(10, 6) NOT NULL, risk_premium_amount NUMERIC(10, 6) DEFAULT NULL, function_bonus_amount NUMERIC(10, 6) DEFAULT NULL, month VARCHAR(2) NOT NULL, INDEX IDX_9413BB713414710B (agent_id), INDEX IDX_9413BB7140C1FEA7 (year_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE society (id INT AUTO_INCREMENT NOT NULL, province_id INT DEFAULT NULL, rccm_id INT DEFAULT NULL, type_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, trade_name VARCHAR(255) DEFAULT NULL, address LONGTEXT DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, INDEX IDX_D6461F2E946114A (province_id), UNIQUE INDEX UNIQ_D6461F2E6255DE9 (rccm_id), INDEX IDX_D6461F2C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE society_recovery (id INT AUTO_INCREMENT NOT NULL, agent_id INT DEFAULT NULL, type_id INT DEFAULT NULL, society_id INT DEFAULT NULL, certificate_id INT DEFAULT NULL, calling_card_id INT DEFAULT NULL, pv_id INT DEFAULT NULL, form_id INT DEFAULT NULL, expense_report_id INT DEFAULT NULL, proof_of_payment_id INT DEFAULT NULL, province_id INT DEFAULT NULL, is_completed TINYINT(1) NOT NULL, released_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_BAA5E6B83414710B (agent_id), INDEX IDX_BAA5E6B8C54C8C93 (type_id), INDEX IDX_BAA5E6B8E6389D24 (society_id), UNIQUE INDEX UNIQ_BAA5E6B899223FFD (certificate_id), UNIQUE INDEX UNIQ_BAA5E6B8AB40D429 (calling_card_id), UNIQUE INDEX UNIQ_BAA5E6B8E8A4F4B0 (pv_id), UNIQUE INDEX UNIQ_BAA5E6B85FF69B7D (form_id), UNIQUE INDEX UNIQ_BAA5E6B88F758FBA (expense_report_id), UNIQUE INDEX UNIQ_BAA5E6B89F0ED322 (proof_of_payment_id), INDEX IDX_BAA5E6B8E946114A (province_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE society_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_deleted TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, full_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, is_deleted TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649F675F31B (author_id), UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, certificate_id INT DEFAULT NULL, type_id INT DEFAULT NULL, brand VARCHAR(255) NOT NULL, chassis VARCHAR(255) DEFAULT NULL, color VARCHAR(255) DEFAULT NULL, numberplate VARCHAR(255) NOT NULL, is_deleted TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1B80E48699223FFD (certificate_id), INDEX IDX_1B80E486C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_deleted TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE year (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_active TINYINT(1) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D487CFC8E FOREIGN KEY (god_father_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DFE19A1A8 FOREIGN KEY (grade_id) REFERENCES grade (id)');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DAE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DED5CA9E6 FOREIGN KEY (service_id) REFERENCES department_service (id)');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DBE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DCCFA12B8 FOREIGN KEY (profile_id) REFERENCES image_object (id)');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DE946114A FOREIGN KEY (province_id) REFERENCES province (id)');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BA56A273CC FOREIGN KEY (origin_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BA816C6140 FOREIGN KEY (destination_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BA3414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BA40C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BAE946114A FOREIGN KEY (province_id) REFERENCES province (id)');
        $this->addSql('ALTER TABLE department ADD CONSTRAINT FK_CD1DE18A727ACA70 FOREIGN KEY (parent_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE department_service ADD CONSTRAINT FK_5C347231AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA6A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE expense ADD CONSTRAINT FK_2D3A8DA640C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('ALTER TABLE folder ADD CONSTRAINT FK_ECA209CDC54C8C93 FOREIGN KEY (type_id) REFERENCES folder_type (id)');
        $this->addSql('ALTER TABLE folder ADD CONSTRAINT FK_ECA209CDDFF56A4A FOREIGN KEY (doc_object_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE folder ADD CONSTRAINT FK_ECA209CD3414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE fuel_site_fuel ADD CONSTRAINT FK_4C717653598164E0 FOREIGN KEY (fuel_site_id) REFERENCES fuel_site (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fuel_site_fuel ADD CONSTRAINT FK_4C71765397C79677 FOREIGN KEY (fuel_id) REFERENCES fuel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fuel_stock_supply ADD CONSTRAINT FK_2280F8E997C79677 FOREIGN KEY (fuel_id) REFERENCES fuel (id)');
        $this->addSql('ALTER TABLE fuel_stock_supply ADD CONSTRAINT FK_2280F8E9FF28C0D8 FOREIGN KEY (supply_id) REFERENCES fuel_supply (id)');
        $this->addSql('ALTER TABLE grade ADD CONSTRAINT FK_595AAE34AE80F5DF FOREIGN KEY (department_id) REFERENCES department (id)');
        $this->addSql('ALTER TABLE job ADD CONSTRAINT FK_FBD8E0F8ED5CA9E6 FOREIGN KEY (service_id) REFERENCES department_service (id)');
        $this->addSql('ALTER TABLE medical ADD CONSTRAINT FK_77DB075A40C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('ALTER TABLE medical_file ADD CONSTRAINT FK_DF6C9C38592AF3BA FOREIGN KEY (medical_id) REFERENCES medical (id)');
        $this->addSql('ALTER TABLE medical_file ADD CONSTRAINT FK_DF6C9C38DFF56A4A FOREIGN KEY (doc_object_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE medical_file ADD CONSTRAINT FK_DF6C9C38A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C135345B2 FOREIGN KEY (roadmap_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CC467131E FOREIGN KEY (exit_permit_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C85636C81 FOREIGN KEY (mission_order_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CF395DB7B FOREIGN KEY (expense_id) REFERENCES expense (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C3414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C40C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('ALTER TABLE mission_agent ADD CONSTRAINT FK_B61DC3A0BE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission_agent ADD CONSTRAINT FK_B61DC3A03414710B FOREIGN KEY (agent_id) REFERENCES agent (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEC54C8C93 FOREIGN KEY (type_id) REFERENCES property_type (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEE946114A FOREIGN KEY (province_id) REFERENCES province (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE3414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEFBAF8D7F FOREIGN KEY (image_object_id) REFERENCES image_object (id)');
        $this->addSql('ALTER TABLE refueling ADD CONSTRAINT FK_5C524674F6BD1646 FOREIGN KEY (site_id) REFERENCES fuel_site (id)');
        $this->addSql('ALTER TABLE refueling ADD CONSTRAINT FK_5C52467497C79677 FOREIGN KEY (fuel_id) REFERENCES fuel (id)');
        $this->addSql('ALTER TABLE refueling ADD CONSTRAINT FK_5C524674545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE refueling ADD CONSTRAINT FK_5C5246743414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE salary ADD CONSTRAINT FK_9413BB713414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE salary ADD CONSTRAINT FK_9413BB7140C1FEA7 FOREIGN KEY (year_id) REFERENCES year (id)');
        $this->addSql('ALTER TABLE society ADD CONSTRAINT FK_D6461F2E946114A FOREIGN KEY (province_id) REFERENCES province (id)');
        $this->addSql('ALTER TABLE society ADD CONSTRAINT FK_D6461F2E6255DE9 FOREIGN KEY (rccm_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE society ADD CONSTRAINT FK_D6461F2C54C8C93 FOREIGN KEY (type_id) REFERENCES society_type (id)');
        $this->addSql('ALTER TABLE society_recovery ADD CONSTRAINT FK_BAA5E6B83414710B FOREIGN KEY (agent_id) REFERENCES agent (id)');
        $this->addSql('ALTER TABLE society_recovery ADD CONSTRAINT FK_BAA5E6B8C54C8C93 FOREIGN KEY (type_id) REFERENCES society_type (id)');
        $this->addSql('ALTER TABLE society_recovery ADD CONSTRAINT FK_BAA5E6B8E6389D24 FOREIGN KEY (society_id) REFERENCES society (id)');
        $this->addSql('ALTER TABLE society_recovery ADD CONSTRAINT FK_BAA5E6B899223FFD FOREIGN KEY (certificate_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE society_recovery ADD CONSTRAINT FK_BAA5E6B8AB40D429 FOREIGN KEY (calling_card_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE society_recovery ADD CONSTRAINT FK_BAA5E6B8E8A4F4B0 FOREIGN KEY (pv_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE society_recovery ADD CONSTRAINT FK_BAA5E6B85FF69B7D FOREIGN KEY (form_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE society_recovery ADD CONSTRAINT FK_BAA5E6B88F758FBA FOREIGN KEY (expense_report_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE society_recovery ADD CONSTRAINT FK_BAA5E6B89F0ED322 FOREIGN KEY (proof_of_payment_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE society_recovery ADD CONSTRAINT FK_BAA5E6B8E946114A FOREIGN KEY (province_id) REFERENCES province (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649F675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E48699223FFD FOREIGN KEY (certificate_id) REFERENCES doc_object (id)');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E486C54C8C93 FOREIGN KEY (type_id) REFERENCES vehicle_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9D487CFC8E');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9DFE19A1A8');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9DAE80F5DF');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9DED5CA9E6');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9DBE04EA9');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9DA76ED395');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9DCCFA12B8');
        $this->addSql('ALTER TABLE agent DROP FOREIGN KEY FK_268B9C9DE946114A');
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BA56A273CC');
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BA816C6140');
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BA3414710B');
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BA40C1FEA7');
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BAE946114A');
        $this->addSql('ALTER TABLE department DROP FOREIGN KEY FK_CD1DE18A727ACA70');
        $this->addSql('ALTER TABLE department_service DROP FOREIGN KEY FK_5C347231AE80F5DF');
        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA6A76ED395');
        $this->addSql('ALTER TABLE expense DROP FOREIGN KEY FK_2D3A8DA640C1FEA7');
        $this->addSql('ALTER TABLE folder DROP FOREIGN KEY FK_ECA209CDC54C8C93');
        $this->addSql('ALTER TABLE folder DROP FOREIGN KEY FK_ECA209CDDFF56A4A');
        $this->addSql('ALTER TABLE folder DROP FOREIGN KEY FK_ECA209CD3414710B');
        $this->addSql('ALTER TABLE fuel_site_fuel DROP FOREIGN KEY FK_4C717653598164E0');
        $this->addSql('ALTER TABLE fuel_site_fuel DROP FOREIGN KEY FK_4C71765397C79677');
        $this->addSql('ALTER TABLE fuel_stock_supply DROP FOREIGN KEY FK_2280F8E997C79677');
        $this->addSql('ALTER TABLE fuel_stock_supply DROP FOREIGN KEY FK_2280F8E9FF28C0D8');
        $this->addSql('ALTER TABLE grade DROP FOREIGN KEY FK_595AAE34AE80F5DF');
        $this->addSql('ALTER TABLE job DROP FOREIGN KEY FK_FBD8E0F8ED5CA9E6');
        $this->addSql('ALTER TABLE medical DROP FOREIGN KEY FK_77DB075A40C1FEA7');
        $this->addSql('ALTER TABLE medical_file DROP FOREIGN KEY FK_DF6C9C38592AF3BA');
        $this->addSql('ALTER TABLE medical_file DROP FOREIGN KEY FK_DF6C9C38DFF56A4A');
        $this->addSql('ALTER TABLE medical_file DROP FOREIGN KEY FK_DF6C9C38A76ED395');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C135345B2');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CC467131E');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C85636C81');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CF395DB7B');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C3414710B');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CA76ED395');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C40C1FEA7');
        $this->addSql('ALTER TABLE mission_agent DROP FOREIGN KEY FK_B61DC3A0BE6CAE90');
        $this->addSql('ALTER TABLE mission_agent DROP FOREIGN KEY FK_B61DC3A03414710B');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEC54C8C93');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEE946114A');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE3414710B');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEFBAF8D7F');
        $this->addSql('ALTER TABLE refueling DROP FOREIGN KEY FK_5C524674F6BD1646');
        $this->addSql('ALTER TABLE refueling DROP FOREIGN KEY FK_5C52467497C79677');
        $this->addSql('ALTER TABLE refueling DROP FOREIGN KEY FK_5C524674545317D1');
        $this->addSql('ALTER TABLE refueling DROP FOREIGN KEY FK_5C5246743414710B');
        $this->addSql('ALTER TABLE salary DROP FOREIGN KEY FK_9413BB713414710B');
        $this->addSql('ALTER TABLE salary DROP FOREIGN KEY FK_9413BB7140C1FEA7');
        $this->addSql('ALTER TABLE society DROP FOREIGN KEY FK_D6461F2E946114A');
        $this->addSql('ALTER TABLE society DROP FOREIGN KEY FK_D6461F2E6255DE9');
        $this->addSql('ALTER TABLE society DROP FOREIGN KEY FK_D6461F2C54C8C93');
        $this->addSql('ALTER TABLE society_recovery DROP FOREIGN KEY FK_BAA5E6B83414710B');
        $this->addSql('ALTER TABLE society_recovery DROP FOREIGN KEY FK_BAA5E6B8C54C8C93');
        $this->addSql('ALTER TABLE society_recovery DROP FOREIGN KEY FK_BAA5E6B8E6389D24');
        $this->addSql('ALTER TABLE society_recovery DROP FOREIGN KEY FK_BAA5E6B899223FFD');
        $this->addSql('ALTER TABLE society_recovery DROP FOREIGN KEY FK_BAA5E6B8AB40D429');
        $this->addSql('ALTER TABLE society_recovery DROP FOREIGN KEY FK_BAA5E6B8E8A4F4B0');
        $this->addSql('ALTER TABLE society_recovery DROP FOREIGN KEY FK_BAA5E6B85FF69B7D');
        $this->addSql('ALTER TABLE society_recovery DROP FOREIGN KEY FK_BAA5E6B88F758FBA');
        $this->addSql('ALTER TABLE society_recovery DROP FOREIGN KEY FK_BAA5E6B89F0ED322');
        $this->addSql('ALTER TABLE society_recovery DROP FOREIGN KEY FK_BAA5E6B8E946114A');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649F675F31B');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E48699223FFD');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E486C54C8C93');
        $this->addSql('DROP TABLE agent');
        $this->addSql('DROP TABLE assignment');
        $this->addSql('DROP TABLE currency');
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE department_service');
        $this->addSql('DROP TABLE doc_object');
        $this->addSql('DROP TABLE expense');
        $this->addSql('DROP TABLE expense_type');
        $this->addSql('DROP TABLE folder');
        $this->addSql('DROP TABLE folder_type');
        $this->addSql('DROP TABLE fuel');
        $this->addSql('DROP TABLE fuel_site');
        $this->addSql('DROP TABLE fuel_site_fuel');
        $this->addSql('DROP TABLE fuel_stock_supply');
        $this->addSql('DROP TABLE fuel_supply');
        $this->addSql('DROP TABLE grade');
        $this->addSql('DROP TABLE image_object');
        $this->addSql('DROP TABLE job');
        $this->addSql('DROP TABLE medical');
        $this->addSql('DROP TABLE medical_file');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP TABLE mission_agent');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE property_type');
        $this->addSql('DROP TABLE province');
        $this->addSql('DROP TABLE refueling');
        $this->addSql('DROP TABLE salary');
        $this->addSql('DROP TABLE society');
        $this->addSql('DROP TABLE society_recovery');
        $this->addSql('DROP TABLE society_type');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE vehicle');
        $this->addSql('DROP TABLE vehicle_type');
        $this->addSql('DROP TABLE year');
    }
}
