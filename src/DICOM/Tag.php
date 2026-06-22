<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
//
// GENERATED FILE -- do not edit by hand.
// Source: tools/codegen/dicom.dic (DCMTK data dictionary, from DICOM PS3.6).
// Regenerate: php tools/codegen/generateTags.php
declare(strict_types=1);

namespace DICOM;

/**
 * Every standard DICOM data element, addressable by its standard keyword. Type
 * Tag:: in an editor to discover the full set; the same keywords appear in the
 * DICOM standard's data dictionary. Each case resolves to its TagInfo
 * (group/element, value representation, value multiplicity) via info().
 */
enum Tag
{
    case CommandGroupLength;
    case AffectedSOPClassUID;
    case RequestedSOPClassUID;
    case CommandField;
    case MessageID;
    case MessageIDBeingRespondedTo;
    case MoveDestination;
    case Priority;
    case CommandDataSetType;
    case Status;
    case OffendingElement;
    case ErrorComment;
    case ErrorID;
    case AffectedSOPInstanceUID;
    case RequestedSOPInstanceUID;
    case EventTypeID;
    case AttributeIdentifierList;
    case ActionTypeID;
    case NumberOfRemainingSuboperations;
    case NumberOfCompletedSuboperations;
    case NumberOfFailedSuboperations;
    case NumberOfWarningSuboperations;
    case MoveOriginatorApplicationEntityTitle;
    case MoveOriginatorMessageID;
    case FileMetaInformationGroupLength;
    case FileMetaInformationVersion;
    case MediaStorageSOPClassUID;
    case MediaStorageSOPInstanceUID;
    case TransferSyntaxUID;
    case ImplementationClassUID;
    case ImplementationVersionName;
    case SourceApplicationEntityTitle;
    case SendingApplicationEntityTitle;
    case ReceivingApplicationEntityTitle;
    case SourcePresentationAddress;
    case SendingPresentationAddress;
    case ReceivingPresentationAddress;
    case RTVMetaInformationVersion;
    case RTVCommunicationSOPClassUID;
    case RTVCommunicationSOPInstanceUID;
    case RTVSourceIdentifier;
    case RTVFlowIdentifier;
    case RTVFlowRTPSamplingRate;
    case RTVFlowActualFrameDuration;
    case PrivateInformationCreatorUID;
    case PrivateInformation;
    case FileSetID;
    case FileSetDescriptorFileID;
    case SpecificCharacterSetOfFileSetDescriptorFile;
    case OffsetOfTheFirstDirectoryRecordOfTheRootDirectoryEntity;
    case OffsetOfTheLastDirectoryRecordOfTheRootDirectoryEntity;
    case FileSetConsistencyFlag;
    case DirectoryRecordSequence;
    case OffsetOfTheNextDirectoryRecord;
    case RecordInUseFlag;
    case OffsetOfReferencedLowerLevelDirectoryEntity;
    case DirectoryRecordType;
    case PrivateRecordUID;
    case ReferencedFileID;
    case ReferencedSOPClassUIDInFile;
    case ReferencedSOPInstanceUIDInFile;
    case ReferencedTransferSyntaxUIDInFile;
    case ReferencedRelatedGeneralSOPClassUIDInFile;
    case CurrentFrameFunctionalGroupsSequence;
    case SpecificCharacterSet;
    case LanguageCodeSequence;
    case ImageType;
    case InstanceCreationDate;
    case InstanceCreationTime;
    case InstanceCreatorUID;
    case InstanceCoercionDateTime;
    case SOPClassUID;
    case AcquisitionUID;
    case SOPInstanceUID;
    case PyramidUID;
    case RelatedGeneralSOPClassUID;
    case OriginalSpecializedSOPClassUID;
    case SyntheticData;
    case SensitiveContentCodeSequence;
    case StudyDate;
    case SeriesDate;
    case AcquisitionDate;
    case ContentDate;
    case AcquisitionDateTime;
    case StudyTime;
    case SeriesTime;
    case AcquisitionTime;
    case ContentTime;
    case AccessionNumber;
    case IssuerOfAccessionNumberSequence;
    case QueryRetrieveLevel;
    case QueryRetrieveView;
    case RetrieveAETitle;
    case StationAETitle;
    case InstanceAvailability;
    case FailedSOPInstanceUIDList;
    case Modality;
    case ModalitiesInStudy;
    case SOPClassesInStudy;
    case AnatomicRegionsInStudyCodeSequence;
    case ConversionType;
    case PresentationIntentType;
    case Manufacturer;
    case InstitutionName;
    case InstitutionAddress;
    case InstitutionCodeSequence;
    case ReferringPhysicianName;
    case ReferringPhysicianAddress;
    case ReferringPhysicianTelephoneNumbers;
    case ReferringPhysicianIdentificationSequence;
    case ConsultingPhysicianName;
    case ConsultingPhysicianIdentificationSequence;
    case CodeValue;
    case CodingSchemeDesignator;
    case CodingSchemeVersion;
    case CodeMeaning;
    case MappingResource;
    case ContextGroupVersion;
    case ContextGroupLocalVersion;
    case CodingSchemeResourcesSequence;
    case CodingSchemeURLType;
    case ContextGroupExtensionFlag;
    case CodingSchemeUID;
    case ContextGroupExtensionCreatorUID;
    case CodingSchemeURL;
    case ContextIdentifier;
    case CodingSchemeIdentificationSequence;
    case CodingSchemeRegistry;
    case CodingSchemeExternalID;
    case CodingSchemeName;
    case CodingSchemeResponsibleOrganization;
    case ContextUID;
    case MappingResourceUID;
    case LongCodeValue;
    case URNCodeValue;
    case EquivalentCodeSequence;
    case MappingResourceName;
    case ContextGroupIdentificationSequence;
    case MappingResourceIdentificationSequence;
    case TimezoneOffsetFromUTC;
    case ResponsibleGroupCodeSequence;
    case EquipmentModality;
    case ManufacturerRelatedModelGroup;
    case PrivateDataElementCharacteristicsSequence;
    case PrivateGroupReference;
    case PrivateCreatorReference;
    case BlockIdentifyingInformationStatus;
    case NonidentifyingPrivateElements;
    case DeidentificationActionSequence;
    case IdentifyingPrivateElements;
    case DeidentificationAction;
    case PrivateDataElement;
    case PrivateDataElementValueMultiplicity;
    case PrivateDataElementValueRepresentation;
    case PrivateDataElementNumberOfItems;
    case PrivateDataElementName;
    case PrivateDataElementKeyword;
    case PrivateDataElementDescription;
    case PrivateDataElementEncoding;
    case PrivateDataElementDefinitionSequence;
    case ScopeOfInventorySequence;
    case InventoryPurpose;
    case InventoryInstanceDescription;
    case InventoryLevel;
    case ItemInventoryDateTime;
    case RemovedFromOperationalUse;
    case ReasonForRemovalCodeSequence;
    case StoredInstanceBaseURI;
    case FolderAccessURI;
    case FileAccessURI;
    case ContainerFileType;
    case FilenameInContainer;
    case FileOffsetInContainer;
    case FileLengthInContainer;
    case StoredInstanceTransferSyntaxUID;
    case ExtendedMatchingMechanisms;
    case RangeMatchingSequence;
    case ListOfUIDMatchingSequence;
    case EmptyValueMatchingSequence;
    case GeneralMatchingSequence;
    case RequestedStatusInterval;
    case RetainInstances;
    case ExpirationDateTime;
    case TransactionStatus;
    case TransactionStatusComment;
    case FileSetAccessSequence;
    case FileAccessSequence;
    case RecordKey;
    case PriorRecordKey;
    case MetadataSequence;
    case UpdatedMetadataSequence;
    case StudyUpdateDateTime;
    case InventoryAccessEndPointsSequence;
    case StudyAccessEndPointsSequence;
    case IncorporatedInventoryInstanceSequence;
    case InventoriedStudiesSequence;
    case InventoriedSeriesSequence;
    case InventoriedInstancesSequence;
    case InventoryCompletionStatus;
    case NumberOfStudyRecordsInInstance;
    case TotalNumberOfStudyRecords;
    case MaximumNumberOfRecords;
    case StationName;
    case StudyDescription;
    case ProcedureCodeSequence;
    case SeriesDescription;
    case SeriesDescriptionCodeSequence;
    case InstitutionalDepartmentName;
    case InstitutionalDepartmentTypeCodeSequence;
    case PhysiciansOfRecord;
    case PhysiciansOfRecordIdentificationSequence;
    case PerformingPhysicianName;
    case PerformingPhysicianIdentificationSequence;
    case NameOfPhysiciansReadingStudy;
    case PhysiciansReadingStudyIdentificationSequence;
    case OperatorsName;
    case OperatorIdentificationSequence;
    case AdmittingDiagnosesDescription;
    case AdmittingDiagnosesCodeSequence;
    case PyramidDescription;
    case ManufacturerModelName;
    case ReferencedStudySequence;
    case ReferencedPerformedProcedureStepSequence;
    case ReferencedInstancesBySOPClassSequence;
    case ReferencedSeriesSequence;
    case ReferencedPatientSequence;
    case ReferencedVisitSequence;
    case ReferencedStereometricInstanceSequence;
    case ReferencedWaveformSequence;
    case ReferencedImageSequence;
    case ReferencedInstanceSequence;
    case ReferencedRealWorldValueMappingInstanceSequence;
    case ReferencedSegmentationSequence;
    case ReferencedSurfaceSegmentationSequence;
    case ReferencedSOPClassUID;
    case ReferencedSOPInstanceUID;
    case DefinitionSourceSequence;
    case SOPClassesSupported;
    case ReferencedFrameNumber;
    case SimpleFrameList;
    case CalculatedFrameList;
    case TimeRange;
    case FrameExtractionSequence;
    case MultiFrameSourceSOPInstanceUID;
    case RetrieveURL;
    case TransactionUID;
    case WarningReason;
    case FailureReason;
    case FailedSOPSequence;
    case ReferencedSOPSequence;
    case OtherFailuresSequence;
    case FailedStudySequence;
    case StudiesContainingOtherReferencedInstancesSequence;
    case RelatedSeriesSequence;
    case PrincipalDiagnosisCodeSequence;
    case PrimaryDiagnosisCodeSequence;
    case SecondaryDiagnosesCodeSequence;
    case HistologicalDiagnosesCodeSequence;
    case DerivationDescription;
    case SourceImageSequence;
    case StageName;
    case StageNumber;
    case NumberOfStages;
    case ViewName;
    case ViewNumber;
    case NumberOfEventTimers;
    case NumberOfViewsInStage;
    case EventElapsedTimes;
    case EventTimerNames;
    case EventTimerSequence;
    case EventTimeOffset;
    case EventCodeSequence;
    case StartTrim;
    case StopTrim;
    case RecommendedDisplayFrameRate;
    case AnatomicRegionSequence;
    case AnatomicRegionModifierSequence;
    case PrimaryAnatomicStructureSequence;
    case PrimaryAnatomicStructureModifierSequence;
    case AlternateRepresentationSequence;
    case AvailableTransferSyntaxUID;
    case IrradiationEventUID;
    case SourceIrradiationEventSequence;
    case RadiopharmaceuticalAdministrationEventUID;
    case FrameType;
    case ReferencedImageEvidenceSequence;
    case ReferencedRawDataSequence;
    case CreatorVersionUID;
    case DerivationImageSequence;
    case SourceImageEvidenceSequence;
    case PixelPresentation;
    case VolumetricProperties;
    case VolumeBasedCalculationTechnique;
    case ComplexImageComponent;
    case AcquisitionContrast;
    case DerivationCodeSequence;
    case ReferencedPresentationStateSequence;
    case ReferencedOtherPlaneSequence;
    case FrameDisplaySequence;
    case RecommendedDisplayFrameRateInFloat;
    case SkipFrameRangeFlag;
    case PatientName;
    case PersonNamesToUseSequence;
    case NameToUse;
    case NameToUseComment;
    case ThirdPersonPronounsSequence;
    case PronounCodeSequence;
    case PronounComment;
    case PatientID;
    case IssuerOfPatientID;
    case TypeOfPatientID;
    case IssuerOfPatientIDQualifiersSequence;
    case SourcePatientGroupIdentificationSequence;
    case GroupOfPatientsIdentificationSequence;
    case SubjectRelativePositionInImage;
    case PatientBirthDate;
    case PatientBirthTime;
    case PatientBirthDateInAlternativeCalendar;
    case PatientDeathDateInAlternativeCalendar;
    case PatientAlternativeCalendar;
    case PatientSex;
    case GenderIdentitySequence;
    case SexParametersForClinicalUseCategoryComment;
    case SexParametersForClinicalUseCategorySequence;
    case GenderIdentityCodeSequence;
    case GenderIdentityComment;
    case SexParametersForClinicalUseCategoryCodeSequence;
    case SexParametersForClinicalUseCategoryReference;
    case PatientInsurancePlanCodeSequence;
    case PatientPrimaryLanguageCodeSequence;
    case PatientPrimaryLanguageModifierCodeSequence;
    case QualityControlSubject;
    case QualityControlSubjectTypeCodeSequence;
    case StrainDescription;
    case StrainNomenclature;
    case StrainStockNumber;
    case StrainSourceRegistryCodeSequence;
    case StrainStockSequence;
    case StrainSource;
    case StrainAdditionalInformation;
    case StrainCodeSequence;
    case GeneticModificationsSequence;
    case GeneticModificationsDescription;
    case GeneticModificationsNomenclature;
    case GeneticModificationsCodeSequence;
    case OtherPatientNames;
    case OtherPatientIDsSequence;
    case PatientBirthName;
    case PatientAge;
    case PatientSize;
    case PatientSizeCodeSequence;
    case PatientBodyMassIndex;
    case MeasuredAPDimension;
    case MeasuredLateralDimension;
    case PatientWeight;
    case PatientAddress;
    case PatientMotherBirthName;
    case MilitaryRank;
    case BranchOfService;
    case ReferencedPatientPhotoSequence;
    case MedicalAlerts;
    case Allergies;
    case CountryOfResidence;
    case RegionOfResidence;
    case PatientTelephoneNumbers;
    case PatientTelecomInformation;
    case EthnicGroupCodeSequence;
    case EthnicGroups;
    case Occupation;
    case SmokingStatus;
    case AdditionalPatientHistory;
    case PregnancyStatus;
    case LastMenstrualDate;
    case PatientReligiousPreference;
    case PatientSpeciesDescription;
    case PatientSpeciesCodeSequence;
    case PatientSexNeutered;
    case AnatomicalOrientationType;
    case PatientBreedDescription;
    case PatientBreedCodeSequence;
    case BreedRegistrationSequence;
    case BreedRegistrationNumber;
    case BreedRegistryCodeSequence;
    case ResponsiblePerson;
    case ResponsiblePersonRole;
    case ResponsibleOrganization;
    case PatientComments;
    case ExaminedBodyThickness;
    case ClinicalTrialSponsorName;
    case ClinicalTrialProtocolID;
    case ClinicalTrialProtocolName;
    case IssuerOfClinicalTrialProtocolID;
    case OtherClinicalTrialProtocolIDsSequence;
    case ClinicalTrialSiteID;
    case ClinicalTrialSiteName;
    case IssuerOfClinicalTrialSiteID;
    case ClinicalTrialSubjectID;
    case IssuerOfClinicalTrialSubjectID;
    case ClinicalTrialSubjectReadingID;
    case IssuerOfClinicalTrialSubjectReadingID;
    case ClinicalTrialTimePointID;
    case ClinicalTrialTimePointDescription;
    case LongitudinalTemporalOffsetFromEvent;
    case LongitudinalTemporalEventType;
    case ClinicalTrialTimePointTypeCodeSequence;
    case IssuerOfClinicalTrialTimePointID;
    case ClinicalTrialCoordinatingCenterName;
    case PatientIdentityRemoved;
    case DeidentificationMethod;
    case DeidentificationMethodCodeSequence;
    case ClinicalTrialSeriesID;
    case ClinicalTrialSeriesDescription;
    case IssuerOfClinicalTrialSeriesID;
    case ClinicalTrialProtocolEthicsCommitteeName;
    case ClinicalTrialProtocolEthicsCommitteeApprovalNumber;
    case ConsentForClinicalTrialUseSequence;
    case DistributionType;
    case ConsentForDistributionFlag;
    case EthicsCommitteeApprovalEffectivenessStartDate;
    case EthicsCommitteeApprovalEffectivenessEndDate;
    case WhitePoint;
    case PrimaryChromaticities;
    case BatteryLevel;
    case ExposureTimeInSeconds;
    case FNumber;
    case OECFRows;
    case OECFColumns;
    case OECFColumnNames;
    case OECFValues;
    case SpatialFrequencyResponseRows;
    case SpatialFrequencyResponseColumns;
    case SpatialFrequencyResponseColumnNames;
    case SpatialFrequencyResponseValues;
    case ColorFilterArrayPatternRows;
    case ColorFilterArrayPatternColumns;
    case ColorFilterArrayPatternValues;
    case FlashFiringStatus;
    case FlashReturnStatus;
    case FlashMode;
    case FlashFunctionPresent;
    case FlashRedEyeMode;
    case ExposureProgram;
    case SpectralSensitivity;
    case PhotographicSensitivity;
    case SelfTimerMode;
    case SensitivityType;
    case StandardOutputSensitivity;
    case RecommendedExposureIndex;
    case ISOSpeed;
    case ISOSpeedLatitudeyyy;
    case ISOSpeedLatitudezzz;
    case EXIFVersion;
    case ShutterSpeedValue;
    case ApertureValue;
    case BrightnessValue;
    case ExposureBiasValue;
    case MaxApertureValue;
    case SubjectDistance;
    case MeteringMode;
    case LightSource;
    case FocalLength;
    case SubjectArea;
    case MakerNote;
    case Temperature;
    case Humidity;
    case Pressure;
    case WaterDepth;
    case Acceleration;
    case CameraElevationAngle;
    case FlashEnergy;
    case SubjectLocation;
    case PhotographicExposureIndex;
    case SensingMethod;
    case FileSource;
    case SceneType;
    case CustomRendered;
    case ExposureMode;
    case WhiteBalance;
    case DigitalZoomRatio;
    case FocalLengthIn35mmFilm;
    case SceneCaptureType;
    case GainControl;
    case Contrast;
    case Saturation;
    case Sharpness;
    case DeviceSettingDescription;
    case SubjectDistanceRange;
    case CameraOwnerName;
    case LensSpecification;
    case LensMake;
    case LensModel;
    case LensSerialNumber;
    case InteroperabilityIndex;
    case InteroperabilityVersion;
    case GPSVersionID;
    case GPSLatitudeRef;
    case GPSLatitude;
    case GPSLongitudeRef;
    case GPSLongitude;
    case GPSAltitudeRef;
    case GPSAltitude;
    case GPSTimeStamp;
    case GPSSatellites;
    case GPSStatus;
    case GPSMeasureMode;
    case GPSDOP;
    case GPSSpeedRef;
    case GPSSpeed;
    case GPSTrackRef;
    case GPSTrack;
    case GPSImgDirectionRef;
    case GPSImgDirection;
    case GPSMapDatum;
    case GPSDestLatitudeRef;
    case GPSDestLatitude;
    case GPSDestLongitudeRef;
    case GPSDestLongitude;
    case GPSDestBearingRef;
    case GPSDestBearing;
    case GPSDestDistanceRef;
    case GPSDestDistance;
    case GPSProcessingMethod;
    case GPSAreaInformation;
    case GPSDateStamp;
    case GPSDifferential;
    case LightSourcePolarization;
    case EmitterColorTemperature;
    case ContactMethod;
    case ImmersionMedia;
    case OpticalMagnificationFactor;
    case ContrastBolusAgent;
    case ContrastBolusAgentSequence;
    case ContrastBolusT1Relaxivity;
    case ContrastBolusAdministrationRouteSequence;
    case BodyPartExamined;
    case ScanningSequence;
    case SequenceVariant;
    case ScanOptions;
    case MRAcquisitionType;
    case SequenceName;
    case AngioFlag;
    case InterventionDrugInformationSequence;
    case InterventionDrugStopTime;
    case InterventionDrugDose;
    case InterventionDrugCodeSequence;
    case AdditionalDrugSequence;
    case Radiopharmaceutical;
    case InterventionDrugName;
    case InterventionDrugStartTime;
    case InterventionSequence;
    case InterventionStatus;
    case InterventionDescription;
    case CineRate;
    case InitialCineRunState;
    case SliceThickness;
    case KVP;
    case CountsAccumulated;
    case AcquisitionTerminationCondition;
    case EffectiveDuration;
    case AcquisitionStartCondition;
    case AcquisitionStartConditionData;
    case AcquisitionTerminationConditionData;
    case RepetitionTime;
    case EchoTime;
    case InversionTime;
    case NumberOfAverages;
    case ImagingFrequency;
    case ImagedNucleus;
    case EchoNumbers;
    case MagneticFieldStrength;
    case SpacingBetweenSlices;
    case NumberOfPhaseEncodingSteps;
    case DataCollectionDiameter;
    case EchoTrainLength;
    case PercentSampling;
    case PercentPhaseFieldOfView;
    case PixelBandwidth;
    case DeviceSerialNumber;
    case DeviceUID;
    case DeviceID;
    case PlateID;
    case GeneratorID;
    case GridID;
    case CassetteID;
    case GantryID;
    case UniqueDeviceIdentifier;
    case UDISequence;
    case ManufacturerDeviceClassUID;
    case SecondaryCaptureDeviceID;
    case DateOfSecondaryCapture;
    case TimeOfSecondaryCapture;
    case SecondaryCaptureDeviceManufacturer;
    case SecondaryCaptureDeviceManufacturerModelName;
    case SecondaryCaptureDeviceSoftwareVersions;
    case SoftwareVersions;
    case VideoImageFormatAcquired;
    case DigitalImageFormatAcquired;
    case ProtocolName;
    case ContrastBolusRoute;
    case ContrastBolusVolume;
    case ContrastBolusStartTime;
    case ContrastBolusStopTime;
    case ContrastBolusTotalDose;
    case SyringeCounts;
    case ContrastFlowRate;
    case ContrastFlowDuration;
    case ContrastBolusIngredient;
    case ContrastBolusIngredientConcentration;
    case SpatialResolution;
    case TriggerTime;
    case TriggerSourceOrType;
    case NominalInterval;
    case FrameTime;
    case CardiacFramingType;
    case FrameTimeVector;
    case FrameDelay;
    case ImageTriggerDelay;
    case MultiplexGroupTimeOffset;
    case TriggerTimeOffset;
    case SynchronizationTrigger;
    case SynchronizationChannel;
    case TriggerSamplePosition;
    case RadiopharmaceuticalRoute;
    case RadiopharmaceuticalVolume;
    case RadiopharmaceuticalStartTime;
    case RadiopharmaceuticalStopTime;
    case RadionuclideTotalDose;
    case RadionuclideHalfLife;
    case RadionuclidePositronFraction;
    case RadiopharmaceuticalSpecificActivity;
    case RadiopharmaceuticalStartDateTime;
    case RadiopharmaceuticalStopDateTime;
    case BeatRejectionFlag;
    case LowRRValue;
    case HighRRValue;
    case IntervalsAcquired;
    case IntervalsRejected;
    case PVCRejection;
    case SkipBeats;
    case HeartRate;
    case CardiacNumberOfImages;
    case TriggerWindow;
    case ReconstructionDiameter;
    case DistanceSourceToDetector;
    case DistanceSourceToPatient;
    case EstimatedRadiographicMagnificationFactor;
    case GantryDetectorTilt;
    case GantryDetectorSlew;
    case TableHeight;
    case TableTraverse;
    case TableMotion;
    case TableVerticalIncrement;
    case TableLateralIncrement;
    case TableLongitudinalIncrement;
    case TableAngle;
    case TableType;
    case RotationDirection;
    case RadialPosition;
    case ScanArc;
    case AngularStep;
    case CenterOfRotationOffset;
    case FieldOfViewShape;
    case FieldOfViewDimensions;
    case ExposureTime;
    case XRayTubeCurrent;
    case Exposure;
    case ExposureInuAs;
    case AveragePulseWidth;
    case RadiationSetting;
    case RectificationType;
    case RadiationMode;
    case ImageAndFluoroscopyAreaDoseProduct;
    case FilterType;
    case TypeOfFilters;
    case IntensifierSize;
    case ImagerPixelSpacing;
    case Grid;
    case GeneratorPower;
    case CollimatorGridName;
    case CollimatorType;
    case FocalDistance;
    case XFocusCenter;
    case YFocusCenter;
    case FocalSpots;
    case AnodeTargetMaterial;
    case BodyPartThickness;
    case CompressionForce;
    case CompressionPressure;
    case PaddleDescription;
    case CompressionContactArea;
    case AcquisitionMode;
    case DoseModeName;
    case AcquiredSubtractionMaskFlag;
    case FluoroscopyPersistenceFlag;
    case FluoroscopyLastImageHoldPersistenceFlag;
    case UpperLimitNumberOfPersistentFluoroscopyFrames;
    case ContrastBolusAutoInjectionTriggerFlag;
    case ContrastBolusInjectionDelay;
    case XAAcquisitionPhaseDetailsSequence;
    case XAAcquisitionFrameRate;
    case XAPlaneDetailsSequence;
    case AcquisitionFieldOfViewLabel;
    case XRayFilterDetailsSequence;
    case XAAcquisitionDuration;
    case ReconstructionPipelineType;
    case ImageFilterDetailsSequence;
    case AppliedMaskSubtractionFlag;
    case RequestedSeriesDescriptionCodeSequence;
    case DateOfLastCalibration;
    case TimeOfLastCalibration;
    case DateTimeOfLastCalibration;
    case CalibrationDateTime;
    case DateOfManufacture;
    case DateOfInstallation;
    case ConvolutionKernel;
    case ActualFrameDuration;
    case CountRate;
    case PreferredPlaybackSequencing;
    case ReceiveCoilName;
    case TransmitCoilName;
    case PlateType;
    case PhosphorType;
    case WaterEquivalentDiameter;
    case WaterEquivalentDiameterCalculationMethodCodeSequence;
    case ScanVelocity;
    case WholeBodyTechnique;
    case ScanLength;
    case AcquisitionMatrix;
    case InPlanePhaseEncodingDirection;
    case FlipAngle;
    case VariableFlipAngleFlag;
    case SAR;
    case dBdt;
    case B1rms;
    case AcquisitionDeviceProcessingDescription;
    case AcquisitionDeviceProcessingCode;
    case CassetteOrientation;
    case CassetteSize;
    case ExposuresOnPlate;
    case RelativeXRayExposure;
    case ExposureIndex;
    case TargetExposureIndex;
    case DeviationIndex;
    case ColumnAngulation;
    case TomoLayerHeight;
    case TomoAngle;
    case TomoTime;
    case TomoType;
    case TomoClass;
    case NumberOfTomosynthesisSourceImages;
    case PositionerMotion;
    case PositionerType;
    case PositionerPrimaryAngle;
    case PositionerSecondaryAngle;
    case PositionerPrimaryAngleIncrement;
    case PositionerSecondaryAngleIncrement;
    case DetectorPrimaryAngle;
    case DetectorSecondaryAngle;
    case ShutterShape;
    case ShutterLeftVerticalEdge;
    case ShutterRightVerticalEdge;
    case ShutterUpperHorizontalEdge;
    case ShutterLowerHorizontalEdge;
    case CenterOfCircularShutter;
    case RadiusOfCircularShutter;
    case VerticesOfThePolygonalShutter;
    case ShutterPresentationValue;
    case ShutterOverlayGroup;
    case ShutterPresentationColorCIELabValue;
    case OutlineShapeType;
    case OutlineLeftVerticalEdge;
    case OutlineRightVerticalEdge;
    case OutlineUpperHorizontalEdge;
    case OutlineLowerHorizontalEdge;
    case CenterOfCircularOutline;
    case DiameterOfCircularOutline;
    case NumberOfPolygonalVertices;
    case VerticesOfThePolygonalOutline;
    case CollimatorShape;
    case CollimatorLeftVerticalEdge;
    case CollimatorRightVerticalEdge;
    case CollimatorUpperHorizontalEdge;
    case CollimatorLowerHorizontalEdge;
    case CenterOfCircularCollimator;
    case RadiusOfCircularCollimator;
    case VerticesOfThePolygonalCollimator;
    case AcquisitionTimeSynchronized;
    case TimeSource;
    case TimeDistributionProtocol;
    case NTPSourceAddress;
    case PageNumberVector;
    case FrameLabelVector;
    case FramePrimaryAngleVector;
    case FrameSecondaryAngleVector;
    case SliceLocationVector;
    case DisplayWindowLabelVector;
    case NominalScannedPixelSpacing;
    case DigitizingDeviceTransportDirection;
    case RotationOfScannedFilm;
    case BiopsyTargetSequence;
    case TargetUID;
    case LocalizingCursorPosition;
    case CalculatedTargetPosition;
    case TargetLabel;
    case DisplayedZValue;
    case IVUSAcquisition;
    case IVUSPullbackRate;
    case IVUSGatedRate;
    case IVUSPullbackStartFrameNumber;
    case IVUSPullbackStopFrameNumber;
    case LesionNumber;
    case OutputPower;
    case TransducerData;
    case TransducerIdentificationSequence;
    case FocusDepth;
    case ProcessingFunction;
    case MechanicalIndex;
    case BoneThermalIndex;
    case CranialThermalIndex;
    case SoftTissueThermalIndex;
    case SoftTissueFocusThermalIndex;
    case SoftTissueSurfaceThermalIndex;
    case DepthOfScanField;
    case PatientPosition;
    case ViewPosition;
    case ProjectionEponymousNameCodeSequence;
    case Sensitivity;
    case SequenceOfUltrasoundRegions;
    case RegionSpatialFormat;
    case RegionDataType;
    case RegionFlags;
    case RegionLocationMinX0;
    case RegionLocationMinY0;
    case RegionLocationMaxX1;
    case RegionLocationMaxY1;
    case ReferencePixelX0;
    case ReferencePixelY0;
    case PhysicalUnitsXDirection;
    case PhysicalUnitsYDirection;
    case ReferencePixelPhysicalValueX;
    case ReferencePixelPhysicalValueY;
    case PhysicalDeltaX;
    case PhysicalDeltaY;
    case TransducerFrequency;
    case TransducerType;
    case PulseRepetitionFrequency;
    case DopplerCorrectionAngle;
    case SteeringAngle;
    case DopplerSampleVolumeXPosition;
    case DopplerSampleVolumeYPosition;
    case TMLinePositionX0;
    case TMLinePositionY0;
    case TMLinePositionX1;
    case TMLinePositionY1;
    case PixelComponentOrganization;
    case PixelComponentMask;
    case PixelComponentRangeStart;
    case PixelComponentRangeStop;
    case PixelComponentPhysicalUnits;
    case PixelComponentDataType;
    case NumberOfTableBreakPoints;
    case TableOfXBreakPoints;
    case TableOfYBreakPoints;
    case NumberOfTableEntries;
    case TableOfPixelValues;
    case TableOfParameterValues;
    case RWaveTimeVector;
    case ActiveImageAreaOverlayGroup;
    case DetectorConditionsNominalFlag;
    case DetectorTemperature;
    case DetectorType;
    case DetectorConfiguration;
    case DetectorDescription;
    case DetectorMode;
    case DetectorID;
    case DateOfLastDetectorCalibration;
    case TimeOfLastDetectorCalibration;
    case ExposuresOnDetectorSinceLastCalibration;
    case ExposuresOnDetectorSinceManufactured;
    case DetectorTimeSinceLastExposure;
    case DetectorActiveTime;
    case DetectorActivationOffsetFromExposure;
    case DetectorBinning;
    case DetectorElementPhysicalSize;
    case DetectorElementSpacing;
    case DetectorActiveShape;
    case DetectorActiveDimensions;
    case DetectorActiveOrigin;
    case DetectorManufacturerName;
    case DetectorManufacturerModelName;
    case FieldOfViewOrigin;
    case FieldOfViewRotation;
    case FieldOfViewHorizontalFlip;
    case PixelDataAreaOriginRelativeToFOV;
    case PixelDataAreaRotationAngleRelativeToFOV;
    case GridAbsorbingMaterial;
    case GridSpacingMaterial;
    case GridThickness;
    case GridPitch;
    case GridAspectRatio;
    case GridPeriod;
    case GridFocalDistance;
    case FilterMaterial;
    case FilterThicknessMinimum;
    case FilterThicknessMaximum;
    case FilterBeamPathLengthMinimum;
    case FilterBeamPathLengthMaximum;
    case ExposureControlMode;
    case ExposureControlModeDescription;
    case ExposureStatus;
    case PhototimerSetting;
    case ExposureTimeInuS;
    case XRayTubeCurrentInuA;
    case ContentQualification;
    case PulseSequenceName;
    case MRImagingModifierSequence;
    case EchoPulseSequence;
    case InversionRecovery;
    case FlowCompensation;
    case MultipleSpinEcho;
    case MultiPlanarExcitation;
    case PhaseContrast;
    case TimeOfFlightContrast;
    case Spoiling;
    case SteadyStatePulseSequence;
    case EchoPlanarPulseSequence;
    case TagAngleFirstAxis;
    case MagnetizationTransfer;
    case T2Preparation;
    case BloodSignalNulling;
    case SaturationRecovery;
    case SpectrallySelectedSuppression;
    case SpectrallySelectedExcitation;
    case SpatialPresaturation;
    case Tagging;
    case OversamplingPhase;
    case TagSpacingFirstDimension;
    case GeometryOfKSpaceTraversal;
    case SegmentedKSpaceTraversal;
    case RectilinearPhaseEncodeReordering;
    case TagThickness;
    case PartialFourierDirection;
    case CardiacSynchronizationTechnique;
    case ReceiveCoilManufacturerName;
    case MRReceiveCoilSequence;
    case ReceiveCoilType;
    case QuadratureReceiveCoil;
    case MultiCoilDefinitionSequence;
    case MultiCoilConfiguration;
    case MultiCoilElementName;
    case MultiCoilElementUsed;
    case MRTransmitCoilSequence;
    case TransmitCoilManufacturerName;
    case TransmitCoilType;
    case SpectralWidth;
    case ChemicalShiftReference;
    case VolumeLocalizationTechnique;
    case MRAcquisitionFrequencyEncodingSteps;
    case Decoupling;
    case DecoupledNucleus;
    case DecouplingFrequency;
    case DecouplingMethod;
    case DecouplingChemicalShiftReference;
    case KSpaceFiltering;
    case TimeDomainFiltering;
    case NumberOfZeroFills;
    case BaselineCorrection;
    case ParallelReductionFactorInPlane;
    case CardiacRRIntervalSpecified;
    case AcquisitionDuration;
    case FrameAcquisitionDateTime;
    case DiffusionDirectionality;
    case DiffusionGradientDirectionSequence;
    case ParallelAcquisition;
    case ParallelAcquisitionTechnique;
    case InversionTimes;
    case MetaboliteMapDescription;
    case PartialFourier;
    case EffectiveEchoTime;
    case MetaboliteMapCodeSequence;
    case ChemicalShiftSequence;
    case CardiacSignalSource;
    case DiffusionBValue;
    case DiffusionGradientOrientation;
    case VelocityEncodingDirection;
    case VelocityEncodingMinimumValue;
    case VelocityEncodingAcquisitionSequence;
    case NumberOfKSpaceTrajectories;
    case CoverageOfKSpace;
    case SpectroscopyAcquisitionPhaseRows;
    case TransmitterFrequency;
    case ResonantNucleus;
    case FrequencyCorrection;
    case MRSpectroscopyFOVGeometrySequence;
    case SlabThickness;
    case SlabOrientation;
    case MidSlabPosition;
    case MRSpatialSaturationSequence;
    case MRTimingAndRelatedParametersSequence;
    case MREchoSequence;
    case MRModifierSequence;
    case MRDiffusionSequence;
    case CardiacSynchronizationSequence;
    case MRAveragesSequence;
    case MRFOVGeometrySequence;
    case VolumeLocalizationSequence;
    case SpectroscopyAcquisitionDataColumns;
    case DiffusionAnisotropyType;
    case FrameReferenceDateTime;
    case MRMetaboliteMapSequence;
    case ParallelReductionFactorOutOfPlane;
    case SpectroscopyAcquisitionOutOfPlanePhaseSteps;
    case ParallelReductionFactorSecondInPlane;
    case CardiacBeatRejectionTechnique;
    case RespiratoryMotionCompensationTechnique;
    case RespiratorySignalSource;
    case BulkMotionCompensationTechnique;
    case BulkMotionSignalSource;
    case ApplicableSafetyStandardAgency;
    case ApplicableSafetyStandardDescription;
    case OperatingModeSequence;
    case OperatingModeType;
    case OperatingMode;
    case SpecificAbsorptionRateDefinition;
    case GradientOutputType;
    case SpecificAbsorptionRateValue;
    case GradientOutput;
    case FlowCompensationDirection;
    case TaggingDelay;
    case RespiratoryMotionCompensationTechniqueDescription;
    case RespiratorySignalSourceID;
    case MRVelocityEncodingSequence;
    case FirstOrderPhaseCorrection;
    case WaterReferencedPhaseCorrection;
    case MRSpectroscopyAcquisitionType;
    case RespiratoryCyclePosition;
    case VelocityEncodingMaximumValue;
    case TagSpacingSecondDimension;
    case TagAngleSecondAxis;
    case FrameAcquisitionDuration;
    case MRImageFrameTypeSequence;
    case MRSpectroscopyFrameTypeSequence;
    case MRAcquisitionPhaseEncodingStepsInPlane;
    case MRAcquisitionPhaseEncodingStepsOutOfPlane;
    case SpectroscopyAcquisitionPhaseColumns;
    case CardiacCyclePosition;
    case SpecificAbsorptionRateSequence;
    case RFEchoTrainLength;
    case GradientEchoTrainLength;
    case ArterialSpinLabelingContrast;
    case MRArterialSpinLabelingSequence;
    case ASLTechniqueDescription;
    case ASLSlabNumber;
    case ASLSlabThickness;
    case ASLSlabOrientation;
    case ASLMidSlabPosition;
    case ASLContext;
    case ASLPulseTrainDuration;
    case ASLCrusherFlag;
    case ASLCrusherFlowLimit;
    case ASLCrusherDescription;
    case ASLBolusCutoffFlag;
    case ASLBolusCutoffTimingSequence;
    case ASLBolusCutoffTechnique;
    case ASLBolusCutoffDelayTime;
    case ASLSlabSequence;
    case ChemicalShiftMinimumIntegrationLimitInppm;
    case ChemicalShiftMaximumIntegrationLimitInppm;
    case WaterReferenceAcquisition;
    case EchoPeakPosition;
    case CTAcquisitionTypeSequence;
    case AcquisitionType;
    case TubeAngle;
    case CTAcquisitionDetailsSequence;
    case RevolutionTime;
    case SingleCollimationWidth;
    case TotalCollimationWidth;
    case CTTableDynamicsSequence;
    case TableSpeed;
    case TableFeedPerRotation;
    case SpiralPitchFactor;
    case CTGeometrySequence;
    case DataCollectionCenterPatient;
    case CTReconstructionSequence;
    case ReconstructionAlgorithm;
    case ConvolutionKernelGroup;
    case ReconstructionFieldOfView;
    case ReconstructionTargetCenterPatient;
    case ReconstructionAngle;
    case ImageFilter;
    case CTExposureSequence;
    case ReconstructionPixelSpacing;
    case ExposureModulationType;
    case CTXRayDetailsSequence;
    case CTPositionSequence;
    case TablePosition;
    case ExposureTimeInms;
    case CTImageFrameTypeSequence;
    case XRayTubeCurrentInmA;
    case ExposureInmAs;
    case ConstantVolumeFlag;
    case FluoroscopyFlag;
    case DistanceSourceToDataCollectionCenter;
    case ContrastBolusAgentNumber;
    case ContrastBolusIngredientCodeSequence;
    case ContrastAdministrationProfileSequence;
    case ContrastBolusUsageSequence;
    case ContrastBolusAgentAdministered;
    case ContrastBolusAgentDetected;
    case ContrastBolusAgentPhase;
    case CTDIvol;
    case CTDIPhantomTypeCodeSequence;
    case CalciumScoringMassFactorPatient;
    case CalciumScoringMassFactorDevice;
    case EnergyWeightingFactor;
    case CTAdditionalXRaySourceSequence;
    case MultienergyCTAcquisition;
    case MultienergyCTAcquisitionSequence;
    case MultienergyCTProcessingSequence;
    case MultienergyCTCharacteristicsSequence;
    case MultienergyCTXRaySourceSequence;
    case XRaySourceIndex;
    case XRaySourceID;
    case MultienergySourceTechnique;
    case SourceStartDateTime;
    case SourceEndDateTime;
    case SwitchingPhaseNumber;
    case SwitchingPhaseNominalDuration;
    case SwitchingPhaseTransitionDuration;
    case EffectiveBinEnergy;
    case MultienergyCTXRayDetectorSequence;
    case XRayDetectorIndex;
    case XRayDetectorID;
    case MultienergyDetectorType;
    case XRayDetectorLabel;
    case NominalMaxEnergy;
    case NominalMinEnergy;
    case ReferencedXRayDetectorIndex;
    case ReferencedXRaySourceIndex;
    case ReferencedPathIndex;
    case MultienergyCTPathSequence;
    case MultienergyCTPathIndex;
    case MultienergyAcquisitionDescription;
    case MonoenergeticEnergyEquivalent;
    case MaterialCodeSequence;
    case DecompositionMethod;
    case DecompositionDescription;
    case DecompositionAlgorithmIdentificationSequence;
    case DecompositionMaterialSequence;
    case MaterialAttenuationSequence;
    case PhotonEnergy;
    case XRayMassAttenuationCoefficient;
    case MetalArtifactReductionSequence;
    case MetalArtifactReductionApplied;
    case MetalArtifactReductionAlgorithmIdentificationSequence;
    case ProjectionPixelCalibrationSequence;
    case DistanceSourceToIsocenter;
    case DistanceObjectToTableTop;
    case ObjectPixelSpacingInCenterOfBeam;
    case PositionerPositionSequence;
    case TablePositionSequence;
    case CollimatorShapeSequence;
    case PlanesInAcquisition;
    case XAXRFFrameCharacteristicsSequence;
    case FrameAcquisitionSequence;
    case XRayReceptorType;
    case AcquisitionProtocolName;
    case AcquisitionProtocolDescription;
    case ContrastBolusIngredientOpaque;
    case DistanceReceptorPlaneToDetectorHousing;
    case IntensifierActiveShape;
    case IntensifierActiveDimensions;
    case PhysicalDetectorSize;
    case PositionOfIsocenterProjection;
    case FieldOfViewSequence;
    case FieldOfViewDescription;
    case ExposureControlSensingRegionsSequence;
    case ExposureControlSensingRegionShape;
    case ExposureControlSensingRegionLeftVerticalEdge;
    case ExposureControlSensingRegionRightVerticalEdge;
    case ExposureControlSensingRegionUpperHorizontalEdge;
    case ExposureControlSensingRegionLowerHorizontalEdge;
    case CenterOfCircularExposureControlSensingRegion;
    case RadiusOfCircularExposureControlSensingRegion;
    case VerticesOfThePolygonalExposureControlSensingRegion;
    case ColumnAngulationPatient;
    case BeamAngle;
    case FrameDetectorParametersSequence;
    case CalculatedAnatomyThickness;
    case CalibrationSequence;
    case ObjectThicknessSequence;
    case PlaneIdentification;
    case FieldOfViewDimensionsInFloat;
    case IsocenterReferenceSystemSequence;
    case PositionerIsocenterPrimaryAngle;
    case PositionerIsocenterSecondaryAngle;
    case PositionerIsocenterDetectorRotationAngle;
    case TableXPositionToIsocenter;
    case TableYPositionToIsocenter;
    case TableZPositionToIsocenter;
    case TableHorizontalRotationAngle;
    case TableHeadTiltAngle;
    case TableCradleTiltAngle;
    case FrameDisplayShutterSequence;
    case AcquiredImageAreaDoseProduct;
    case CArmPositionerTabletopRelationship;
    case XRayGeometrySequence;
    case IrradiationEventIdentificationSequence;
    case XRay3DFrameTypeSequence;
    case ContributingSourcesSequence;
    case XRay3DAcquisitionSequence;
    case PrimaryPositionerScanArc;
    case SecondaryPositionerScanArc;
    case PrimaryPositionerScanStartAngle;
    case SecondaryPositionerScanStartAngle;
    case PrimaryPositionerIncrement;
    case SecondaryPositionerIncrement;
    case StartAcquisitionDateTime;
    case EndAcquisitionDateTime;
    case PrimaryPositionerIncrementSign;
    case SecondaryPositionerIncrementSign;
    case ApplicationName;
    case ApplicationVersion;
    case ApplicationManufacturer;
    case AlgorithmType;
    case AlgorithmDescription;
    case XRay3DReconstructionSequence;
    case ReconstructionDescription;
    case PerProjectionAcquisitionSequence;
    case DetectorPositionSequence;
    case XRayAcquisitionDoseSequence;
    case XRaySourceIsocenterPrimaryAngle;
    case XRaySourceIsocenterSecondaryAngle;
    case BreastSupportIsocenterPrimaryAngle;
    case BreastSupportIsocenterSecondaryAngle;
    case BreastSupportXPositionToIsocenter;
    case BreastSupportYPositionToIsocenter;
    case BreastSupportZPositionToIsocenter;
    case DetectorIsocenterPrimaryAngle;
    case DetectorIsocenterSecondaryAngle;
    case DetectorXPositionToIsocenter;
    case DetectorYPositionToIsocenter;
    case DetectorZPositionToIsocenter;
    case XRayGridSequence;
    case XRayFilterSequence;
    case DetectorActiveAreaTLHCPosition;
    case DetectorActiveAreaOrientation;
    case PositionerPrimaryAngleDirection;
    case DiffusionBMatrixSequence;
    case DiffusionBValueXX;
    case DiffusionBValueXY;
    case DiffusionBValueXZ;
    case DiffusionBValueYY;
    case DiffusionBValueYZ;
    case DiffusionBValueZZ;
    case FunctionalMRSequence;
    case FunctionalSettlingPhaseFramesPresent;
    case FunctionalSyncPulse;
    case SettlingPhaseFrame;
    case DecayCorrectionDateTime;
    case StartDensityThreshold;
    case StartRelativeDensityDifferenceThreshold;
    case StartCardiacTriggerCountThreshold;
    case StartRespiratoryTriggerCountThreshold;
    case TerminationCountsThreshold;
    case TerminationDensityThreshold;
    case TerminationRelativeDensityThreshold;
    case TerminationTimeThreshold;
    case TerminationCardiacTriggerCountThreshold;
    case TerminationRespiratoryTriggerCountThreshold;
    case DetectorGeometry;
    case TransverseDetectorSeparation;
    case AxialDetectorDimension;
    case RadiopharmaceuticalAgentNumber;
    case PETFrameAcquisitionSequence;
    case PETDetectorMotionDetailsSequence;
    case PETTableDynamicsSequence;
    case PETPositionSequence;
    case PETFrameCorrectionFactorsSequence;
    case RadiopharmaceuticalUsageSequence;
    case AttenuationCorrectionSource;
    case NumberOfIterations;
    case NumberOfSubsets;
    case PETReconstructionSequence;
    case PETFrameTypeSequence;
    case TimeOfFlightInformationUsed;
    case ReconstructionType;
    case DecayCorrected;
    case AttenuationCorrected;
    case ScatterCorrected;
    case DeadTimeCorrected;
    case GantryMotionCorrected;
    case PatientMotionCorrected;
    case CountLossNormalizationCorrected;
    case RandomsCorrected;
    case NonUniformRadialSamplingCorrected;
    case SensitivityCalibrated;
    case DetectorNormalizationCorrection;
    case IterativeReconstructionMethod;
    case AttenuationCorrectionTemporalRelationship;
    case PatientPhysiologicalStateSequence;
    case PatientPhysiologicalStateCodeSequence;
    case DepthsOfFocus;
    case ExcludedIntervalsSequence;
    case ExclusionStartDateTime;
    case ExclusionDuration;
    case USImageDescriptionSequence;
    case ImageDataTypeSequence;
    case DataType;
    case TransducerScanPatternCodeSequence;
    case AliasedDataType;
    case PositionMeasuringDeviceUsed;
    case TransducerGeometryCodeSequence;
    case TransducerBeamSteeringCodeSequence;
    case TransducerApplicationCodeSequence;
    case ZeroVelocityPixelValue;
    case PhotoacousticExcitationCharacteristicsSequence;
    case ExcitationSpectralWidth;
    case ExcitationEnergy;
    case ExcitationPulseDuration;
    case ExcitationWavelengthSequence;
    case ExcitationWavelength;
    case IlluminationTranslationFlag;
    case AcousticCouplingMediumFlag;
    case AcousticCouplingMediumCodeSequence;
    case AcousticCouplingMediumTemperature;
    case TransducerResponseSequence;
    case CenterFrequency;
    case FractionalBandwidth;
    case LowerCutoffFrequency;
    case UpperCutoffFrequency;
    case TransducerTechnologySequence;
    case SoundSpeedCorrectionMechanismCodeSequence;
    case ObjectSoundSpeed;
    case AcousticCouplingMediumSoundSpeed;
    case PhotoacousticImageFrameTypeSequence;
    case ImageDataTypeCodeSequence;
    case ReferenceLocationLabel;
    case ReferenceLocationDescription;
    case ReferenceBasisCodeSequence;
    case ReferenceGeometryCodeSequence;
    case OffsetDistance;
    case OffsetDirection;
    case PotentialScheduledProtocolCodeSequence;
    case PotentialRequestedProcedureCodeSequence;
    case PotentialReasonsForProcedure;
    case PotentialReasonsForProcedureCodeSequence;
    case PotentialDiagnosticTasks;
    case ContraindicationsCodeSequence;
    case ReferencedDefinedProtocolSequence;
    case ReferencedPerformedProtocolSequence;
    case PredecessorProtocolSequence;
    case ProtocolPlanningInformation;
    case ProtocolDesignRationale;
    case PatientSpecificationSequence;
    case ModelSpecificationSequence;
    case ParametersSpecificationSequence;
    case InstructionSequence;
    case InstructionIndex;
    case InstructionText;
    case InstructionDescription;
    case InstructionPerformedFlag;
    case InstructionPerformedDateTime;
    case InstructionPerformanceComment;
    case PatientPositioningInstructionSequence;
    case PositioningMethodCodeSequence;
    case PositioningLandmarkSequence;
    case TargetFrameOfReferenceUID;
    case AcquisitionProtocolElementSpecificationSequence;
    case AcquisitionProtocolElementSequence;
    case ProtocolElementNumber;
    case ProtocolElementName;
    case ProtocolElementCharacteristicsSummary;
    case ProtocolElementPurpose;
    case AcquisitionMotion;
    case AcquisitionStartLocationSequence;
    case AcquisitionEndLocationSequence;
    case ReconstructionProtocolElementSpecificationSequence;
    case ReconstructionProtocolElementSequence;
    case StorageProtocolElementSpecificationSequence;
    case StorageProtocolElementSequence;
    case RequestedSeriesDescription;
    case SourceAcquisitionProtocolElementNumber;
    case SourceAcquisitionBeamNumber;
    case SourceReconstructionProtocolElementNumber;
    case ReconstructionStartLocationSequence;
    case ReconstructionEndLocationSequence;
    case ReconstructionAlgorithmSequence;
    case ReconstructionTargetCenterLocationSequence;
    case ImageFilterDescription;
    case CTDIvolNotificationTrigger;
    case DLPNotificationTrigger;
    case AutoKVPSelectionType;
    case AutoKVPUpperBound;
    case AutoKVPLowerBound;
    case ProtocolDefinedPatientPosition;
    case ContributingEquipmentSequence;
    case ContributionDateTime;
    case ContributionDescription;
    case StudyInstanceUID;
    case SeriesInstanceUID;
    case StudyID;
    case SeriesNumber;
    case AcquisitionNumber;
    case InstanceNumber;
    case ItemNumber;
    case PatientOrientation;
    case PyramidLabel;
    case ImagePositionPatient;
    case ImageOrientationPatient;
    case FrameOfReferenceUID;
    case Laterality;
    case ImageLaterality;
    case TemporalPositionIdentifier;
    case NumberOfTemporalPositions;
    case TemporalResolution;
    case SynchronizationFrameOfReferenceUID;
    case SOPInstanceUIDOfConcatenationSource;
    case ImagesInAcquisition;
    case TargetPositionReferenceIndicator;
    case PositionReferenceIndicator;
    case SliceLocation;
    case NumberOfPatientRelatedStudies;
    case NumberOfPatientRelatedSeries;
    case NumberOfPatientRelatedInstances;
    case NumberOfStudyRelatedSeries;
    case NumberOfStudyRelatedInstances;
    case NumberOfSeriesRelatedInstances;
    case ImageComments;
    case StackID;
    case InStackPositionNumber;
    case FrameAnatomySequence;
    case FrameLaterality;
    case FrameContentSequence;
    case PlanePositionSequence;
    case PlaneOrientationSequence;
    case TemporalPositionIndex;
    case NominalCardiacTriggerDelayTime;
    case NominalCardiacTriggerTimePriorToRPeak;
    case ActualCardiacTriggerTimePriorToRPeak;
    case FrameAcquisitionNumber;
    case DimensionIndexValues;
    case FrameComments;
    case ConcatenationUID;
    case InConcatenationNumber;
    case InConcatenationTotalNumber;
    case DimensionOrganizationUID;
    case DimensionIndexPointer;
    case FunctionalGroupPointer;
    case UnassignedSharedConvertedAttributesSequence;
    case UnassignedPerFrameConvertedAttributesSequence;
    case ConversionSourceAttributesSequence;
    case DimensionIndexPrivateCreator;
    case DimensionOrganizationSequence;
    case DimensionIndexSequence;
    case ConcatenationFrameOffsetNumber;
    case FunctionalGroupPrivateCreator;
    case NominalPercentageOfCardiacPhase;
    case NominalPercentageOfRespiratoryPhase;
    case StartingRespiratoryAmplitude;
    case StartingRespiratoryPhase;
    case EndingRespiratoryAmplitude;
    case EndingRespiratoryPhase;
    case RespiratoryTriggerType;
    case RRIntervalTimeNominal;
    case ActualCardiacTriggerDelayTime;
    case RespiratorySynchronizationSequence;
    case RespiratoryIntervalTime;
    case NominalRespiratoryTriggerDelayTime;
    case RespiratoryTriggerDelayThreshold;
    case ActualRespiratoryTriggerDelayTime;
    case ImagePositionVolume;
    case ImageOrientationVolume;
    case UltrasoundAcquisitionGeometry;
    case ApexPosition;
    case VolumeToTransducerMappingMatrix;
    case VolumeToTableMappingMatrix;
    case VolumeToTransducerRelationship;
    case PatientFrameOfReferenceSource;
    case TemporalPositionTimeOffset;
    case PlanePositionVolumeSequence;
    case PlaneOrientationVolumeSequence;
    case TemporalPositionSequence;
    case DimensionOrganizationType;
    case VolumeFrameOfReferenceUID;
    case TableFrameOfReferenceUID;
    case DimensionDescriptionLabel;
    case PatientOrientationInFrameSequence;
    case FrameLabel;
    case AcquisitionIndex;
    case ContributingSOPInstancesReferenceSequence;
    case ReconstructionIndex;
    case LightPathFilterPassThroughWavelength;
    case LightPathFilterPassBand;
    case ImagePathFilterPassThroughWavelength;
    case ImagePathFilterPassBand;
    case PatientEyeMovementCommanded;
    case PatientEyeMovementCommandCodeSequence;
    case SphericalLensPower;
    case CylinderLensPower;
    case CylinderAxis;
    case EmmetropicMagnification;
    case IntraOcularPressure;
    case HorizontalFieldOfView;
    case PupilDilated;
    case DegreeOfDilation;
    case VertexDistance;
    case StereoBaselineAngle;
    case StereoBaselineDisplacement;
    case StereoHorizontalPixelOffset;
    case StereoVerticalPixelOffset;
    case StereoRotation;
    case AcquisitionDeviceTypeCodeSequence;
    case IlluminationTypeCodeSequence;
    case LightPathFilterTypeStackCodeSequence;
    case ImagePathFilterTypeStackCodeSequence;
    case LensesCodeSequence;
    case ChannelDescriptionCodeSequence;
    case RefractiveStateSequence;
    case MydriaticAgentCodeSequence;
    case RelativeImagePositionCodeSequence;
    case CameraAngleOfView;
    case StereoPairsSequence;
    case LeftImageSequence;
    case RightImageSequence;
    case StereoPairsPresent;
    case AxialLengthOfTheEye;
    case OphthalmicFrameLocationSequence;
    case ReferenceCoordinates;
    case DepthSpatialResolution;
    case MaximumDepthDistortion;
    case AlongScanSpatialResolution;
    case MaximumAlongScanDistortion;
    case OphthalmicImageOrientation;
    case DepthOfTransverseImage;
    case MydriaticAgentConcentrationUnitsSequence;
    case AcrossScanSpatialResolution;
    case MaximumAcrossScanDistortion;
    case MydriaticAgentConcentration;
    case IlluminationWaveLength;
    case IlluminationPower;
    case IlluminationBandwidth;
    case MydriaticAgentSequence;
    case OphthalmicAxialMeasurementsRightEyeSequence;
    case OphthalmicAxialMeasurementsLeftEyeSequence;
    case OphthalmicAxialMeasurementsDeviceType;
    case OphthalmicAxialLengthMeasurementsType;
    case OphthalmicAxialLengthSequence;
    case OphthalmicAxialLength;
    case LensStatusCodeSequence;
    case VitreousStatusCodeSequence;
    case IOLFormulaCodeSequence;
    case IOLFormulaDetail;
    case KeratometerIndex;
    case SourceOfOphthalmicAxialLengthCodeSequence;
    case SourceOfCornealSizeDataCodeSequence;
    case TargetRefraction;
    case RefractiveProcedureOccurred;
    case RefractiveSurgeryTypeCodeSequence;
    case OphthalmicUltrasoundMethodCodeSequence;
    case SurgicallyInducedAstigmatismSequence;
    case TypeOfOpticalCorrection;
    case ToricIOLPowerSequence;
    case PredictedToricErrorSequence;
    case PreSelectedForImplantation;
    case ToricIOLPowerForExactEmmetropiaSequence;
    case ToricIOLPowerForExactTargetRefractionSequence;
    case OphthalmicAxialLengthMeasurementsSequence;
    case IOLPower;
    case PredictedRefractiveError;
    case OphthalmicAxialLengthVelocity;
    case LensStatusDescription;
    case VitreousStatusDescription;
    case IOLPowerSequence;
    case LensConstantSequence;
    case IOLManufacturer;
    case ImplantName;
    case KeratometryMeasurementTypeCodeSequence;
    case ImplantPartNumber;
    case ReferencedOphthalmicAxialMeasurementsSequence;
    case OphthalmicAxialLengthMeasurementsSegmentNameCodeSequence;
    case RefractiveErrorBeforeRefractiveSurgeryCodeSequence;
    case IOLPowerForExactEmmetropia;
    case IOLPowerForExactTargetRefraction;
    case AnteriorChamberDepthDefinitionCodeSequence;
    case LensThicknessSequence;
    case AnteriorChamberDepthSequence;
    case CalculationCommentSequence;
    case CalculationCommentType;
    case CalculationComment;
    case LensThickness;
    case AnteriorChamberDepth;
    case SourceOfLensThicknessDataCodeSequence;
    case SourceOfAnteriorChamberDepthDataCodeSequence;
    case SourceOfRefractiveMeasurementsSequence;
    case SourceOfRefractiveMeasurementsCodeSequence;
    case OphthalmicAxialLengthMeasurementModified;
    case OphthalmicAxialLengthDataSourceCodeSequence;
    case SignalToNoiseRatio;
    case OphthalmicAxialLengthDataSourceDescription;
    case OphthalmicAxialLengthMeasurementsTotalLengthSequence;
    case OphthalmicAxialLengthMeasurementsSegmentalLengthSequence;
    case OphthalmicAxialLengthMeasurementsLengthSummationSequence;
    case UltrasoundOphthalmicAxialLengthMeasurementsSequence;
    case OpticalOphthalmicAxialLengthMeasurementsSequence;
    case UltrasoundSelectedOphthalmicAxialLengthSequence;
    case OphthalmicAxialLengthSelectionMethodCodeSequence;
    case OpticalSelectedOphthalmicAxialLengthSequence;
    case SelectedSegmentalOphthalmicAxialLengthSequence;
    case SelectedTotalOphthalmicAxialLengthSequence;
    case OphthalmicAxialLengthQualityMetricSequence;
    case IntraocularLensCalculationsRightEyeSequence;
    case IntraocularLensCalculationsLeftEyeSequence;
    case ReferencedOphthalmicAxialLengthMeasurementQCImageSequence;
    case OphthalmicMappingDeviceType;
    case AcquisitionMethodCodeSequence;
    case AcquisitionMethodAlgorithmSequence;
    case OphthalmicThicknessMapTypeCodeSequence;
    case OphthalmicThicknessMappingNormalsSequence;
    case RetinalThicknessDefinitionCodeSequence;
    case PixelValueMappingToCodedConceptSequence;
    case MappedPixelValue;
    case PixelValueMappingExplanation;
    case OphthalmicThicknessMapQualityThresholdSequence;
    case OphthalmicThicknessMapThresholdQualityRating;
    case AnatomicStructureReferencePoint;
    case RegistrationToLocalizerSequence;
    case RegisteredLocalizerUnits;
    case RegisteredLocalizerTopLeftHandCorner;
    case RegisteredLocalizerBottomRightHandCorner;
    case OphthalmicThicknessMapQualityRatingSequence;
    case RelevantOPTAttributesSequence;
    case TransformationMethodCodeSequence;
    case TransformationAlgorithmSequence;
    case OphthalmicAxialLengthMethod;
    case OphthalmicFOV;
    case TwoDimensionalToThreeDimensionalMapSequence;
    case WideFieldOphthalmicPhotographyQualityRatingSequence;
    case WideFieldOphthalmicPhotographyQualityThresholdSequence;
    case WideFieldOphthalmicPhotographyThresholdQualityRating;
    case XCoordinatesCenterPixelViewAngle;
    case YCoordinatesCenterPixelViewAngle;
    case NumberOfMapPoints;
    case TwoDimensionalToThreeDimensionalMapData;
    case DerivationAlgorithmSequence;
    case OphthalmicImageTypeCodeSequence;
    case OphthalmicImageTypeDescription;
    case ScanPatternTypeCodeSequence;
    case ReferencedSurfaceMeshIdentificationSequence;
    case OphthalmicVolumetricPropertiesFlag;
    case OphthalmicAnatomicReferencePointFrameCoordinate;
    case OphthalmicAnatomicReferencePointXCoordinate;
    case OphthalmicAnatomicReferencePointYCoordinate;
    case OphthalmicEnFaceVolumeDescriptorSequence;
    case OphthalmicEnFaceImageQualityRatingSequence;
    case OphthalmicEnFaceVolumeDescriptorScope;
    case QualityThreshold;
    case OphthalmicAnatomicReferencePointSequence;
    case OphthalmicAnatomicReferencePointLocalizationType;
    case PrimaryAnatomicStructureItemIndex;
    case OCTBscanAnalysisAcquisitionParametersSequence;
    case NumberOfBscansPerFrame;
    case BscanSlabThickness;
    case DistanceBetweenBscanSlabs;
    case BscanCycleTime;
    case BscanCycleTimeVector;
    case AscanRate;
    case BscanRate;
    case SurfaceMeshZPixelOffset;
    case VisualFieldHorizontalExtent;
    case VisualFieldVerticalExtent;
    case VisualFieldShape;
    case ScreeningTestModeCodeSequence;
    case MaximumStimulusLuminance;
    case BackgroundLuminance;
    case StimulusColorCodeSequence;
    case BackgroundIlluminationColorCodeSequence;
    case StimulusArea;
    case StimulusPresentationTime;
    case FixationSequence;
    case FixationMonitoringCodeSequence;
    case VisualFieldCatchTrialSequence;
    case FixationCheckedQuantity;
    case PatientNotProperlyFixatedQuantity;
    case PresentedVisualStimuliDataFlag;
    case NumberOfVisualStimuli;
    case ExcessiveFixationLossesDataFlag;
    case ExcessiveFixationLosses;
    case StimuliRetestingQuantity;
    case CommentsOnPatientPerformanceOfVisualField;
    case FalseNegativesEstimateFlag;
    case FalseNegativesEstimate;
    case NegativeCatchTrialsQuantity;
    case FalseNegativesQuantity;
    case ExcessiveFalseNegativesDataFlag;
    case ExcessiveFalseNegatives;
    case FalsePositivesEstimateFlag;
    case FalsePositivesEstimate;
    case CatchTrialsDataFlag;
    case PositiveCatchTrialsQuantity;
    case TestPointNormalsDataFlag;
    case TestPointNormalsSequence;
    case GlobalDeviationProbabilityNormalsFlag;
    case FalsePositivesQuantity;
    case ExcessiveFalsePositivesDataFlag;
    case ExcessiveFalsePositives;
    case VisualFieldTestNormalsFlag;
    case ResultsNormalsSequence;
    case AgeCorrectedSensitivityDeviationAlgorithmSequence;
    case GlobalDeviationFromNormal;
    case GeneralizedDefectSensitivityDeviationAlgorithmSequence;
    case LocalizedDeviationFromNormal;
    case PatientReliabilityIndicator;
    case VisualFieldMeanSensitivity;
    case GlobalDeviationProbability;
    case LocalDeviationProbabilityNormalsFlag;
    case LocalizedDeviationProbability;
    case ShortTermFluctuationCalculated;
    case ShortTermFluctuation;
    case ShortTermFluctuationProbabilityCalculated;
    case ShortTermFluctuationProbability;
    case CorrectedLocalizedDeviationFromNormalCalculated;
    case CorrectedLocalizedDeviationFromNormal;
    case CorrectedLocalizedDeviationFromNormalProbabilityCalculated;
    case CorrectedLocalizedDeviationFromNormalProbability;
    case GlobalDeviationProbabilitySequence;
    case LocalizedDeviationProbabilitySequence;
    case FovealSensitivityMeasured;
    case FovealSensitivity;
    case VisualFieldTestDuration;
    case VisualFieldTestPointSequence;
    case VisualFieldTestPointXCoordinate;
    case VisualFieldTestPointYCoordinate;
    case AgeCorrectedSensitivityDeviationValue;
    case StimulusResults;
    case SensitivityValue;
    case RetestStimulusSeen;
    case RetestSensitivityValue;
    case VisualFieldTestPointNormalsSequence;
    case QuantifiedDefect;
    case AgeCorrectedSensitivityDeviationProbabilityValue;
    case GeneralizedDefectCorrectedSensitivityDeviationFlag;
    case GeneralizedDefectCorrectedSensitivityDeviationValue;
    case GeneralizedDefectCorrectedSensitivityDeviationProbabilityValue;
    case MinimumSensitivityValue;
    case BlindSpotLocalized;
    case BlindSpotXCoordinate;
    case BlindSpotYCoordinate;
    case VisualAcuityMeasurementSequence;
    case RefractiveParametersUsedOnPatientSequence;
    case MeasurementLaterality;
    case OphthalmicPatientClinicalInformationLeftEyeSequence;
    case OphthalmicPatientClinicalInformationRightEyeSequence;
    case FovealPointNormativeDataFlag;
    case FovealPointProbabilityValue;
    case ScreeningBaselineMeasured;
    case ScreeningBaselineMeasuredSequence;
    case ScreeningBaselineType;
    case ScreeningBaselineValue;
    case AlgorithmSource;
    case DataSetName;
    case DataSetVersion;
    case DataSetSource;
    case DataSetDescription;
    case VisualFieldTestReliabilityGlobalIndexSequence;
    case VisualFieldGlobalResultsIndexSequence;
    case DataObservationSequence;
    case IndexNormalsFlag;
    case IndexProbability;
    case IndexProbabilitySequence;
    case SamplesPerPixel;
    case SamplesPerPixelUsed;
    case PhotometricInterpretation;
    case PlanarConfiguration;
    case NumberOfFrames;
    case FrameIncrementPointer;
    case FrameDimensionPointer;
    case Rows;
    case Columns;
    case UltrasoundColorDataPresent;
    case PixelSpacing;
    case ZoomFactor;
    case ZoomCenter;
    case PixelAspectRatio;
    case CorrectedImage;
    case BitsAllocated;
    case BitsStored;
    case HighBit;
    case PixelRepresentation;
    case SmallestImagePixelValue;
    case LargestImagePixelValue;
    case SmallestPixelValueInSeries;
    case LargestPixelValueInSeries;
    case PixelPaddingValue;
    case PixelPaddingRangeLimit;
    case FloatPixelPaddingValue;
    case DoubleFloatPixelPaddingValue;
    case FloatPixelPaddingRangeLimit;
    case DoubleFloatPixelPaddingRangeLimit;
    case QualityControlImage;
    case BurnedInAnnotation;
    case RecognizableVisualFeatures;
    case LongitudinalTemporalInformationModified;
    case ReferencedColorPaletteInstanceUID;
    case PixelSpacingCalibrationType;
    case PixelSpacingCalibrationDescription;
    case PixelIntensityRelationship;
    case PixelIntensityRelationshipSign;
    case WindowCenter;
    case WindowWidth;
    case RescaleIntercept;
    case RescaleSlope;
    case RescaleType;
    case WindowCenterWidthExplanation;
    case VOILUTFunction;
    case RecommendedViewingMode;
    case RedPaletteColorLookupTableDescriptor;
    case GreenPaletteColorLookupTableDescriptor;
    case BluePaletteColorLookupTableDescriptor;
    case AlphaPaletteColorLookupTableDescriptor;
    case PaletteColorLookupTableUID;
    case RedPaletteColorLookupTableData;
    case GreenPaletteColorLookupTableData;
    case BluePaletteColorLookupTableData;
    case AlphaPaletteColorLookupTableData;
    case SegmentedRedPaletteColorLookupTableData;
    case SegmentedGreenPaletteColorLookupTableData;
    case SegmentedBluePaletteColorLookupTableData;
    case SegmentedAlphaPaletteColorLookupTableData;
    case StoredValueColorRangeSequence;
    case MinimumStoredValueMapped;
    case MaximumStoredValueMapped;
    case BreastImplantPresent;
    case PartialView;
    case PartialViewDescription;
    case PartialViewCodeSequence;
    case SpatialLocationsPreserved;
    case DataFrameAssignmentSequence;
    case DataPathAssignment;
    case BitsMappedToColorLookupTable;
    case BlendingLUT1Sequence;
    case BlendingLUT1TransferFunction;
    case BlendingWeightConstant;
    case BlendingLookupTableDescriptor;
    case BlendingLookupTableData;
    case EnhancedPaletteColorLookupTableSequence;
    case BlendingLUT2Sequence;
    case BlendingLUT2TransferFunction;
    case DataPathID;
    case RGBLUTTransferFunction;
    case AlphaLUTTransferFunction;
    case ICCProfile;
    case ColorSpace;
    case LossyImageCompression;
    case LossyImageCompressionRatio;
    case LossyImageCompressionMethod;
    case ModalityLUTSequence;
    case VariableModalityLUTSequence;
    case LUTDescriptor;
    case LUTExplanation;
    case ModalityLUTType;
    case LUTData;
    case VOILUTSequence;
    case SoftcopyVOILUTSequence;
    case RepresentativeFrameNumber;
    case FrameNumbersOfInterest;
    case FrameOfInterestDescription;
    case FrameOfInterestType;
    case RWavePointer;
    case MaskSubtractionSequence;
    case MaskOperation;
    case ApplicableFrameRange;
    case MaskFrameNumbers;
    case ContrastFrameAveraging;
    case MaskSubPixelShift;
    case TIDOffset;
    case MaskOperationExplanation;
    case EquipmentAdministratorSequence;
    case NumberOfDisplaySubsystems;
    case CurrentConfigurationID;
    case DisplaySubsystemID;
    case DisplaySubsystemName;
    case DisplaySubsystemDescription;
    case SystemStatus;
    case SystemStatusComment;
    case TargetLuminanceCharacteristicsSequence;
    case LuminanceCharacteristicsID;
    case DisplaySubsystemConfigurationSequence;
    case ConfigurationID;
    case ConfigurationName;
    case ConfigurationDescription;
    case ReferencedTargetLuminanceCharacteristicsID;
    case QAResultsSequence;
    case DisplaySubsystemQAResultsSequence;
    case ConfigurationQAResultsSequence;
    case MeasurementEquipmentSequence;
    case MeasurementFunctions;
    case MeasurementEquipmentType;
    case VisualEvaluationResultSequence;
    case DisplayCalibrationResultSequence;
    case DDLValue;
    case CIExyWhitePoint;
    case DisplayFunctionType;
    case GammaValue;
    case NumberOfLuminancePoints;
    case LuminanceResponseSequence;
    case TargetMinimumLuminance;
    case TargetMaximumLuminance;
    case LuminanceValue;
    case LuminanceResponseDescription;
    case WhitePointFlag;
    case DisplayDeviceTypeCodeSequence;
    case DisplaySubsystemSequence;
    case LuminanceResultSequence;
    case AmbientLightValueSource;
    case MeasuredCharacteristics;
    case LuminanceUniformityResultSequence;
    case VisualEvaluationTestSequence;
    case TestResult;
    case TestResultComment;
    case TestImageValidation;
    case TestPatternCodeSequence;
    case MeasurementPatternCodeSequence;
    case VisualEvaluationMethodCodeSequence;
    case PixelDataProviderURL;
    case DataPointRows;
    case DataPointColumns;
    case SignalDomainColumns;
    case DataRepresentation;
    case PixelMeasuresSequence;
    case FrameVOILUTSequence;
    case PixelValueTransformationSequence;
    case SignalDomainRows;
    case DisplayFilterPercentage;
    case FramePixelShiftSequence;
    case SubtractionItemID;
    case PixelIntensityRelationshipLUTSequence;
    case FramePixelDataPropertiesSequence;
    case GeometricalProperties;
    case GeometricMaximumDistortion;
    case ImageProcessingApplied;
    case MaskSelectionMode;
    case LUTFunction;
    case MaskVisibilityPercentage;
    case PixelShiftSequence;
    case RegionPixelShiftSequence;
    case VerticesOfTheRegion;
    case MultiFramePresentationSequence;
    case PixelShiftFrameRange;
    case LUTFrameRange;
    case ImageToEquipmentMappingMatrix;
    case EquipmentCoordinateSystemIdentification;
    case RequestingPhysicianIdentificationSequence;
    case RequestingPhysician;
    case RequestingService;
    case RequestingServiceCodeSequence;
    case RequestedProcedureDescription;
    case RequestedProcedureCodeSequence;
    case RequestedLateralityCodeSequence;
    case ReasonForVisit;
    case ReasonForVisitCodeSequence;
    case RequestedContrastAgent;
    case FlowIdentifierSequence;
    case FlowIdentifier;
    case FlowTransferSyntaxUID;
    case FlowRTPSamplingRate;
    case SourceIdentifier;
    case FrameOriginTimestamp;
    case IncludesImagingSubject;
    case FrameUsefulnessGroupSequence;
    case RealTimeBulkDataFlowSequence;
    case CameraPositionGroupSequence;
    case IncludesInformation;
    case TimeOfFrameGroupSequence;
    case VisitStatusID;
    case AdmissionID;
    case IssuerOfAdmissionIDSequence;
    case RouteOfAdmissions;
    case AdmittingDate;
    case AdmittingTime;
    case SpecialNeeds;
    case ServiceEpisodeID;
    case ServiceEpisodeDescription;
    case IssuerOfServiceEpisodeIDSequence;
    case PertinentDocumentsSequence;
    case PertinentResourcesSequence;
    case ResourceDescription;
    case CurrentPatientLocation;
    case PatientInstitutionResidence;
    case PatientState;
    case PatientClinicalTrialParticipationSequence;
    case VisitComments;
    case WaveformOriginality;
    case NumberOfWaveformChannels;
    case NumberOfWaveformSamples;
    case SamplingFrequency;
    case MultiplexGroupLabel;
    case ChannelDefinitionSequence;
    case WaveformChannelNumber;
    case ChannelLabel;
    case ChannelStatus;
    case ChannelSourceSequence;
    case ChannelSourceModifiersSequence;
    case SourceWaveformSequence;
    case ChannelDerivationDescription;
    case ChannelSensitivity;
    case ChannelSensitivityUnitsSequence;
    case ChannelSensitivityCorrectionFactor;
    case ChannelBaseline;
    case ChannelTimeSkew;
    case ChannelSampleSkew;
    case ChannelOffset;
    case WaveformBitsStored;
    case FilterLowFrequency;
    case FilterHighFrequency;
    case NotchFilterFrequency;
    case NotchFilterBandwidth;
    case WaveformDataDisplayScale;
    case WaveformDisplayBackgroundCIELabValue;
    case WaveformPresentationGroupSequence;
    case PresentationGroupNumber;
    case ChannelDisplaySequence;
    case ChannelRecommendedDisplayCIELabValue;
    case ChannelPosition;
    case DisplayShadingFlag;
    case FractionalChannelDisplayScale;
    case AbsoluteChannelDisplayScale;
    case MultiplexedAudioChannelsDescriptionCodeSequence;
    case ChannelIdentificationCode;
    case ChannelMode;
    case MultiplexGroupUID;
    case PowerlineFrequency;
    case ChannelImpedanceSequence;
    case ImpedanceValue;
    case ImpedanceMeasurementDateTime;
    case ImpedanceMeasurementFrequency;
    case ImpedanceMeasurementCurrentType;
    case WaveformAmplifierType;
    case FilterLowFrequencyCharacteristicsSequence;
    case FilterHighFrequencyCharacteristicsSequence;
    case SummarizedFilterLookupTableSequence;
    case NotchFilterCharacteristicsSequence;
    case WaveformFilterType;
    case AnalogFilterCharacteristicsSequence;
    case AnalogFilterRollOff;
    case AnalogFilterTypeCodeSequence;
    case DigitalFilterCharacteristicsSequence;
    case DigitalFilterOrder;
    case DigitalFilterTypeCodeSequence;
    case WaveformFilterDescription;
    case FilterLookupTableSequence;
    case FilterLookupTableDescription;
    case FrequencyEncodingCodeSequence;
    case MagnitudeEncodingCodeSequence;
    case FilterLookupTableData;
    case ScheduledStationAETitle;
    case ScheduledProcedureStepStartDate;
    case ScheduledProcedureStepStartTime;
    case ScheduledProcedureStepEndDate;
    case ScheduledProcedureStepEndTime;
    case ScheduledPerformingPhysicianName;
    case ScheduledProcedureStepDescription;
    case ScheduledProtocolCodeSequence;
    case ScheduledProcedureStepID;
    case StageCodeSequence;
    case ScheduledPerformingPhysicianIdentificationSequence;
    case ScheduledStationName;
    case ScheduledProcedureStepLocation;
    case PreMedication;
    case ScheduledProcedureStepStatus;
    case OrderPlacerIdentifierSequence;
    case OrderFillerIdentifierSequence;
    case LocalNamespaceEntityID;
    case UniversalEntityID;
    case UniversalEntityIDType;
    case IdentifierTypeCode;
    case AssigningFacilitySequence;
    case AssigningJurisdictionCodeSequence;
    case AssigningAgencyOrDepartmentCodeSequence;
    case ScheduledProcedureStepSequence;
    case ReferencedNonImageCompositeSOPInstanceSequence;
    case PerformedStationAETitle;
    case PerformedStationName;
    case PerformedLocation;
    case PerformedProcedureStepStartDate;
    case PerformedProcedureStepStartTime;
    case PerformedProcedureStepEndDate;
    case PerformedProcedureStepEndTime;
    case PerformedProcedureStepStatus;
    case PerformedProcedureStepID;
    case PerformedProcedureStepDescription;
    case PerformedProcedureTypeDescription;
    case PerformedProtocolCodeSequence;
    case PerformedProtocolType;
    case ScheduledStepAttributesSequence;
    case RequestAttributesSequence;
    case CommentsOnThePerformedProcedureStep;
    case PerformedProcedureStepDiscontinuationReasonCodeSequence;
    case QuantitySequence;
    case Quantity;
    case MeasuringUnitsSequence;
    case BillingItemSequence;
    case EntranceDose;
    case ExposedArea;
    case DistanceSourceToEntrance;
    case CommentsOnRadiationDose;
    case XRayOutput;
    case HalfValueLayer;
    case OrganDose;
    case OrganExposed;
    case BillingProcedureStepSequence;
    case FilmConsumptionSequence;
    case BillingSuppliesAndDevicesSequence;
    case PerformedSeriesSequence;
    case CommentsOnTheScheduledProcedureStep;
    case ProtocolContextSequence;
    case ContentItemModifierSequence;
    case ScheduledSpecimenSequence;
    case ContainerIdentifier;
    case IssuerOfTheContainerIdentifierSequence;
    case AlternateContainerIdentifierSequence;
    case ContainerTypeCodeSequence;
    case ContainerDescription;
    case ContainerComponentSequence;
    case SpecimenIdentifier;
    case SpecimenUID;
    case AcquisitionContextSequence;
    case AcquisitionContextDescription;
    case SpecimenDescriptionSequence;
    case IssuerOfTheSpecimenIdentifierSequence;
    case SpecimenTypeCodeSequence;
    case SpecimenShortDescription;
    case SpecimenDetailedDescription;
    case SpecimenPreparationSequence;
    case SpecimenPreparationStepContentItemSequence;
    case SpecimenLocalizationContentItemSequence;
    case WholeSlideMicroscopyImageFrameTypeSequence;
    case ImageCenterPointCoordinatesSequence;
    case XOffsetInSlideCoordinateSystem;
    case YOffsetInSlideCoordinateSystem;
    case ZOffsetInSlideCoordinateSystem;
    case MeasurementUnitsCodeSequence;
    case RequestedProcedureID;
    case ReasonForTheRequestedProcedure;
    case RequestedProcedurePriority;
    case PatientTransportArrangements;
    case RequestedProcedureLocation;
    case ConfidentialityCode;
    case ReportingPriority;
    case ReasonForRequestedProcedureCodeSequence;
    case NamesOfIntendedRecipientsOfResults;
    case IntendedRecipientsOfResultsIdentificationSequence;
    case ReasonForPerformedProcedureCodeSequence;
    case PersonIdentificationCodeSequence;
    case PersonAddress;
    case PersonTelephoneNumbers;
    case PersonTelecomInformation;
    case RequestedProcedureComments;
    case IssueDateOfImagingServiceRequest;
    case IssueTimeOfImagingServiceRequest;
    case OrderEnteredBy;
    case OrderEntererLocation;
    case OrderCallbackPhoneNumber;
    case OrderCallbackTelecomInformation;
    case PlacerOrderNumberImagingServiceRequest;
    case FillerOrderNumberImagingServiceRequest;
    case ImagingServiceRequestComments;
    case ConfidentialityConstraintOnPatientDataDescription;
    case ScheduledProcedureStepStartDateTime;
    case ScheduledProcedureStepExpirationDateTime;
    case HumanPerformerCodeSequence;
    case ScheduledProcedureStepModificationDateTime;
    case ExpectedCompletionDateTime;
    case ScheduledWorkitemCodeSequence;
    case PerformedWorkitemCodeSequence;
    case InputInformationSequence;
    case ScheduledStationNameCodeSequence;
    case ScheduledStationClassCodeSequence;
    case ScheduledStationGeographicLocationCodeSequence;
    case PerformedStationNameCodeSequence;
    case PerformedStationClassCodeSequence;
    case PerformedStationGeographicLocationCodeSequence;
    case OutputInformationSequence;
    case ScheduledHumanPerformersSequence;
    case ActualHumanPerformersSequence;
    case HumanPerformerOrganization;
    case HumanPerformerName;
    case RawDataHandling;
    case InputReadinessState;
    case PerformedProcedureStepStartDateTime;
    case PerformedProcedureStepEndDateTime;
    case ProcedureStepCancellationDateTime;
    case OutputDestinationSequence;
    case DICOMStorageSequence;
    case STOWRSStorageSequence;
    case StorageURL;
    case XDSStorageSequence;
    case EntranceDoseInmGy;
    case EntranceDoseDerivation;
    case ParametricMapFrameTypeSequence;
    case ReferencedImageRealWorldValueMappingSequence;
    case RealWorldValueMappingSequence;
    case PixelValueMappingCodeSequence;
    case LUTLabel;
    case RealWorldValueLastValueMapped;
    case RealWorldValueLUTData;
    case DoubleFloatRealWorldValueLastValueMapped;
    case DoubleFloatRealWorldValueFirstValueMapped;
    case RealWorldValueFirstValueMapped;
    case QuantityDefinitionSequence;
    case RealWorldValueIntercept;
    case RealWorldValueSlope;
    case RelationshipType;
    case VerifyingOrganization;
    case VerificationDateTime;
    case ObservationDateTime;
    case ObservationStartDateTime;
    case EffectiveStartDateTime;
    case EffectiveStopDateTime;
    case ValueType;
    case ConceptNameCodeSequence;
    case ContinuityOfContent;
    case VerifyingObserverSequence;
    case VerifyingObserverName;
    case AuthorObserverSequence;
    case ParticipantSequence;
    case CustodialOrganizationSequence;
    case ParticipationType;
    case ParticipationDateTime;
    case ObserverType;
    case VerifyingObserverIdentificationCodeSequence;
    case ReferencedWaveformChannels;
    case DateTime;
    case Date;
    case Time;
    case PersonName;
    case UID;
    case TemporalRangeType;
    case ReferencedSamplePositions;
    case ReferencedTimeOffsets;
    case ReferencedDateTime;
    case TextValue;
    case FloatingPointValue;
    case RationalNumeratorValue;
    case RationalDenominatorValue;
    case ConceptCodeSequence;
    case PurposeOfReferenceCodeSequence;
    case ObservationUID;
    case AnnotationGroupNumber;
    case ModifierCodeSequence;
    case MeasuredValueSequence;
    case NumericValueQualifierCodeSequence;
    case NumericValue;
    case PredecessorDocumentsSequence;
    case ReferencedRequestSequence;
    case PerformedProcedureCodeSequence;
    case CurrentRequestedProcedureEvidenceSequence;
    case PertinentOtherEvidenceSequence;
    case HL7StructuredDocumentReferenceSequence;
    case CompletionFlag;
    case CompletionFlagDescription;
    case VerificationFlag;
    case ArchiveRequested;
    case PreliminaryFlag;
    case ContentTemplateSequence;
    case IdenticalDocumentsSequence;
    case ContentSequence;
    case TabulatedValuesSequence;
    case NumberOfTableRows;
    case NumberOfTableColumns;
    case TableRowNumber;
    case TableColumnNumber;
    case TableRowDefinitionSequence;
    case TableColumnDefinitionSequence;
    case CellValuesSequence;
    case WaveformAnnotationSequence;
    case StructuredWaveformAnnotationSequence;
    case WaveformAnnotationDisplaySelectionSequence;
    case ReferencedMontageIndex;
    case WaveformTextualAnnotationSequence;
    case AnnotationDateTime;
    case DisplayedWaveformSegmentSequence;
    case SegmentDefinitionDateTime;
    case MontageActivationSequence;
    case MontageActivationTimeOffset;
    case WaveformMontageSequence;
    case ReferencedMontageChannelNumber;
    case MontageName;
    case MontageChannelSequence;
    case MontageIndex;
    case MontageChannelNumber;
    case MontageChannelLabel;
    case MontageChannelSourceCodeSequence;
    case ContributingChannelSourcesSequence;
    case ChannelWeight;
    case TemplateIdentifier;
    case ReferencedContentItemIdentifier;
    case HL7InstanceIdentifier;
    case HL7DocumentEffectiveTime;
    case HL7DocumentTypeCodeSequence;
    case DocumentClassCodeSequence;
    case RetrieveURI;
    case RetrieveLocationUID;
    case TypeOfInstances;
    case DICOMRetrievalSequence;
    case DICOMMediaRetrievalSequence;
    case WADORetrievalSequence;
    case XDSRetrievalSequence;
    case WADORSRetrievalSequence;
    case RepositoryUniqueID;
    case HomeCommunityID;
    case DocumentTitle;
    case EncapsulatedDocument;
    case MIMETypeOfEncapsulatedDocument;
    case SourceInstanceSequence;
    case ListOfMIMETypes;
    case EncapsulatedDocumentLength;
    case ProductPackageIdentifier;
    case SubstanceAdministrationApproval;
    case ApprovalStatusFurtherDescription;
    case ApprovalStatusDateTime;
    case ProductTypeCodeSequence;
    case ProductName;
    case ProductDescription;
    case ProductLotIdentifier;
    case ProductExpirationDateTime;
    case SubstanceAdministrationDateTime;
    case SubstanceAdministrationNotes;
    case SubstanceAdministrationDeviceID;
    case ProductParameterSequence;
    case SubstanceAdministrationParameterSequence;
    case ApprovalSequence;
    case AssertionCodeSequence;
    case AssertionUID;
    case AsserterIdentificationSequence;
    case AssertionDateTime;
    case AssertionExpirationDateTime;
    case AssertionComments;
    case RelatedAssertionSequence;
    case ReferencedAssertionUID;
    case ApprovalSubjectSequence;
    case OrganizationalRoleCodeSequence;
    case RTAssertionsSequence;
    case LensDescription;
    case RightLensSequence;
    case LeftLensSequence;
    case UnspecifiedLateralityLensSequence;
    case CylinderSequence;
    case PrismSequence;
    case HorizontalPrismPower;
    case HorizontalPrismBase;
    case VerticalPrismPower;
    case VerticalPrismBase;
    case LensSegmentType;
    case OpticalTransmittance;
    case ChannelWidth;
    case PupilSize;
    case CornealSize;
    case CornealSizeSequence;
    case AutorefractionRightEyeSequence;
    case AutorefractionLeftEyeSequence;
    case DistancePupillaryDistance;
    case NearPupillaryDistance;
    case IntermediatePupillaryDistance;
    case OtherPupillaryDistance;
    case KeratometryRightEyeSequence;
    case KeratometryLeftEyeSequence;
    case SteepKeratometricAxisSequence;
    case RadiusOfCurvature;
    case KeratometricPower;
    case KeratometricAxis;
    case FlatKeratometricAxisSequence;
    case BackgroundColor;
    case Optotype;
    case OptotypePresentation;
    case SubjectiveRefractionRightEyeSequence;
    case SubjectiveRefractionLeftEyeSequence;
    case AddNearSequence;
    case AddIntermediateSequence;
    case AddOtherSequence;
    case AddPower;
    case ViewingDistance;
    case CorneaMeasurementsSequence;
    case SourceOfCorneaMeasurementDataCodeSequence;
    case SteepCornealAxisSequence;
    case FlatCornealAxisSequence;
    case CornealPower;
    case CornealAxis;
    case CorneaMeasurementMethodCodeSequence;
    case RefractiveIndexOfCornea;
    case RefractiveIndexOfAqueousHumor;
    case VisualAcuityTypeCodeSequence;
    case VisualAcuityRightEyeSequence;
    case VisualAcuityLeftEyeSequence;
    case VisualAcuityBothEyesOpenSequence;
    case ViewingDistanceType;
    case VisualAcuityModifiers;
    case DecimalVisualAcuity;
    case OptotypeDetailedDefinition;
    case ReferencedRefractiveMeasurementsSequence;
    case SpherePower;
    case CylinderPower;
    case CornealTopographySurface;
    case CornealVertexLocation;
    case PupilCentroidXCoordinate;
    case PupilCentroidYCoordinate;
    case EquivalentPupilRadius;
    case CornealTopographyMapTypeCodeSequence;
    case VerticesOfTheOutlineOfPupil;
    case CornealTopographyMappingNormalsSequence;
    case MaximumCornealCurvatureSequence;
    case MaximumCornealCurvature;
    case MaximumCornealCurvatureLocation;
    case MinimumKeratometricSequence;
    case SimulatedKeratometricCylinderSequence;
    case AverageCornealPower;
    case CornealISValue;
    case AnalyzedArea;
    case SurfaceRegularityIndex;
    case SurfaceAsymmetryIndex;
    case CornealEccentricityIndex;
    case KeratoconusPredictionIndex;
    case DecimalPotentialVisualAcuity;
    case CornealTopographyMapQualityEvaluation;
    case SourceImageCornealProcessedDataSequence;
    case CornealPointLocation;
    case CornealPointEstimated;
    case AxialPower;
    case TangentialPower;
    case RefractivePower;
    case RelativeElevation;
    case CornealWavefront;
    case ImagedVolumeWidth;
    case ImagedVolumeHeight;
    case ImagedVolumeDepth;
    case TotalPixelMatrixColumns;
    case TotalPixelMatrixRows;
    case TotalPixelMatrixOriginSequence;
    case SpecimenLabelInImage;
    case FocusMethod;
    case ExtendedDepthOfField;
    case NumberOfFocalPlanes;
    case DistanceBetweenFocalPlanes;
    case RecommendedAbsentPixelCIELabValue;
    case IlluminatorTypeCodeSequence;
    case ImageOrientationSlide;
    case OpticalPathSequence;
    case OpticalPathIdentifier;
    case OpticalPathDescription;
    case IlluminationColorCodeSequence;
    case SpecimenReferenceSequence;
    case CondenserLensPower;
    case ObjectiveLensPower;
    case ObjectiveLensNumericalAperture;
    case ConfocalMode;
    case TissueLocation;
    case ConfocalMicroscopyImageFrameTypeSequence;
    case ImageAcquisitionDepth;
    case PaletteColorLookupTableSequence;
    case OpticalPathIdentificationSequence;
    case PlanePositionSlideSequence;
    case ColumnPositionInTotalImagePixelMatrix;
    case RowPositionInTotalImagePixelMatrix;
    case PixelOriginInterpretation;
    case NumberOfOpticalPaths;
    case TotalPixelMatrixFocalPlanes;
    case TilesOverlap;
    case CalibrationImage;
    case DeviceSequence;
    case ContainerComponentTypeCodeSequence;
    case ContainerComponentThickness;
    case DeviceLength;
    case ContainerComponentWidth;
    case DeviceDiameter;
    case DeviceDiameterUnits;
    case DeviceVolume;
    case InterMarkerDistance;
    case ContainerComponentMaterial;
    case ContainerComponentID;
    case ContainerComponentLength;
    case ContainerComponentDiameter;
    case ContainerComponentDescription;
    case DeviceDescription;
    case LongDeviceDescription;
    case ContrastBolusIngredientPercentByVolume;
    case OCTFocalDistance;
    case BeamSpotSize;
    case EffectiveRefractiveIndex;
    case OCTAcquisitionDomain;
    case OCTOpticalCenterWavelength;
    case AxialResolution;
    case RangingDepth;
    case ALineRate;
    case ALinesPerFrame;
    case CatheterRotationalRate;
    case ALinePixelSpacing;
    case ModeOfPercutaneousAccessSequence;
    case IntravascularOCTFrameTypeSequence;
    case OCTZOffsetApplied;
    case IntravascularFrameContentSequence;
    case IntravascularLongitudinalDistance;
    case IntravascularOCTFrameContentSequence;
    case OCTZOffsetCorrection;
    case CatheterDirectionOfRotation;
    case SeamLineLocation;
    case FirstALineLocation;
    case SeamLineIndex;
    case NumberOfPaddedALines;
    case InterpolationType;
    case RefractiveIndexApplied;
    case EnergyWindowVector;
    case NumberOfEnergyWindows;
    case EnergyWindowInformationSequence;
    case EnergyWindowRangeSequence;
    case EnergyWindowLowerLimit;
    case EnergyWindowUpperLimit;
    case RadiopharmaceuticalInformationSequence;
    case ResidualSyringeCounts;
    case EnergyWindowName;
    case DetectorVector;
    case NumberOfDetectors;
    case DetectorInformationSequence;
    case PhaseVector;
    case NumberOfPhases;
    case PhaseInformationSequence;
    case NumberOfFramesInPhase;
    case PhaseDelay;
    case PauseBetweenFrames;
    case PhaseDescription;
    case RotationVector;
    case NumberOfRotations;
    case RotationInformationSequence;
    case NumberOfFramesInRotation;
    case RRIntervalVector;
    case NumberOfRRIntervals;
    case GatedInformationSequence;
    case DataInformationSequence;
    case TimeSlotVector;
    case NumberOfTimeSlots;
    case TimeSlotInformationSequence;
    case TimeSlotTime;
    case SliceVector;
    case NumberOfSlices;
    case AngularViewVector;
    case TimeSliceVector;
    case NumberOfTimeSlices;
    case StartAngle;
    case TypeOfDetectorMotion;
    case TriggerVector;
    case NumberOfTriggersInPhase;
    case ViewCodeSequence;
    case ViewModifierCodeSequence;
    case RadionuclideCodeSequence;
    case AdministrationRouteCodeSequence;
    case RadiopharmaceuticalCodeSequence;
    case CalibrationDataSequence;
    case EnergyWindowNumber;
    case ImageID;
    case PatientOrientationCodeSequence;
    case PatientOrientationModifierCodeSequence;
    case PatientGantryRelationshipCodeSequence;
    case SliceProgressionDirection;
    case ScanProgressionDirection;
    case SeriesType;
    case Units;
    case CountsSource;
    case ReprojectionMethod;
    case SUVType;
    case RandomsCorrectionMethod;
    case AttenuationCorrectionMethod;
    case DecayCorrection;
    case ReconstructionMethod;
    case DetectorLinesOfResponseUsed;
    case ScatterCorrectionMethod;
    case AxialAcceptance;
    case AxialMash;
    case TransverseMash;
    case DetectorElementSize;
    case CoincidenceWindowWidth;
    case SecondaryCountsType;
    case FrameReferenceTime;
    case PrimaryPromptsCountsAccumulated;
    case SecondaryCountsAccumulated;
    case SliceSensitivityFactor;
    case DecayFactor;
    case DoseCalibrationFactor;
    case ScatterFractionFactor;
    case DeadTimeFactor;
    case ImageIndex;
    case HistogramSequence;
    case HistogramNumberOfBins;
    case HistogramFirstBinValue;
    case HistogramLastBinValue;
    case HistogramBinWidth;
    case HistogramExplanation;
    case HistogramData;
    case SegmentationType;
    case SegmentSequence;
    case SegmentedPropertyCategoryCodeSequence;
    case SegmentNumber;
    case SegmentLabel;
    case SegmentDescription;
    case SegmentationAlgorithmIdentificationSequence;
    case SegmentAlgorithmType;
    case SegmentAlgorithmName;
    case SegmentIdentificationSequence;
    case ReferencedSegmentNumber;
    case RecommendedDisplayGrayscaleValue;
    case RecommendedDisplayCIELabValue;
    case MaximumFractionalValue;
    case SegmentedPropertyTypeCodeSequence;
    case SegmentationFractionalType;
    case SegmentedPropertyTypeModifierCodeSequence;
    case UsedSegmentsSequence;
    case SegmentsOverlap;
    case TrackingID;
    case TrackingUID;
    case DeformableRegistrationSequence;
    case SourceFrameOfReferenceUID;
    case DeformableRegistrationGridSequence;
    case GridDimensions;
    case GridResolution;
    case VectorGridData;
    case PreDeformationMatrixRegistrationSequence;
    case PostDeformationMatrixRegistrationSequence;
    case NumberOfSurfaces;
    case SurfaceSequence;
    case SurfaceNumber;
    case SurfaceComments;
    case SurfaceOffset;
    case SurfaceProcessing;
    case SurfaceProcessingRatio;
    case SurfaceProcessingDescription;
    case RecommendedPresentationOpacity;
    case RecommendedPresentationType;
    case FiniteVolume;
    case Manifold;
    case SurfacePointsSequence;
    case SurfacePointsNormalsSequence;
    case SurfaceMeshPrimitivesSequence;
    case NumberOfSurfacePoints;
    case PointCoordinatesData;
    case PointPositionAccuracy;
    case MeanPointDistance;
    case MaximumPointDistance;
    case PointsBoundingBoxCoordinates;
    case AxisOfRotation;
    case CenterOfRotation;
    case NumberOfVectors;
    case VectorDimensionality;
    case VectorAccuracy;
    case VectorCoordinateData;
    case DoublePointCoordinatesData;
    case TriangleStripSequence;
    case TriangleFanSequence;
    case LineSequence;
    case SurfaceCount;
    case ReferencedSurfaceSequence;
    case ReferencedSurfaceNumber;
    case SegmentSurfaceGenerationAlgorithmIdentificationSequence;
    case SegmentSurfaceSourceInstanceSequence;
    case AlgorithmFamilyCodeSequence;
    case AlgorithmNameCodeSequence;
    case AlgorithmVersion;
    case AlgorithmParameters;
    case FacetSequence;
    case SurfaceProcessingAlgorithmIdentificationSequence;
    case AlgorithmName;
    case RecommendedPointRadius;
    case RecommendedLineThickness;
    case LongPrimitivePointIndexList;
    case LongTrianglePointIndexList;
    case LongEdgePointIndexList;
    case LongVertexPointIndexList;
    case TrackSetSequence;
    case TrackSequence;
    case RecommendedDisplayCIELabValueList;
    case TrackingAlgorithmIdentificationSequence;
    case TrackSetNumber;
    case TrackSetLabel;
    case TrackSetDescription;
    case TrackSetAnatomicalTypeCodeSequence;
    case MeasurementsSequence;
    case TrackSetStatisticsSequence;
    case FloatingPointValues;
    case TrackPointIndexList;
    case TrackStatisticsSequence;
    case MeasurementValuesSequence;
    case DiffusionAcquisitionCodeSequence;
    case DiffusionModelCodeSequence;
    case ImplantSize;
    case ImplantTemplateVersion;
    case ReplacedImplantTemplateSequence;
    case ImplantType;
    case DerivationImplantTemplateSequence;
    case OriginalImplantTemplateSequence;
    case EffectiveDateTime;
    case ImplantTargetAnatomySequence;
    case InformationFromManufacturerSequence;
    case NotificationFromManufacturerSequence;
    case InformationIssueDateTime;
    case InformationSummary;
    case ImplantRegulatoryDisapprovalCodeSequence;
    case OverallTemplateSpatialTolerance;
    case HPGLDocumentSequence;
    case HPGLDocumentID;
    case HPGLDocumentLabel;
    case ViewOrientationCodeSequence;
    case ViewOrientationModifierCodeSequence;
    case HPGLDocumentScaling;
    case HPGLDocument;
    case HPGLContourPenNumber;
    case HPGLPenSequence;
    case HPGLPenNumber;
    case HPGLPenLabel;
    case HPGLPenDescription;
    case RecommendedRotationPoint;
    case BoundingRectangle;
    case ImplantTemplate3DModelSurfaceNumber;
    case SurfaceModelDescriptionSequence;
    case SurfaceModelLabel;
    case SurfaceModelScalingFactor;
    case MaterialsCodeSequence;
    case CoatingMaterialsCodeSequence;
    case ImplantTypeCodeSequence;
    case FixationMethodCodeSequence;
    case MatingFeatureSetsSequence;
    case MatingFeatureSetID;
    case MatingFeatureSetLabel;
    case MatingFeatureSequence;
    case MatingFeatureID;
    case MatingFeatureDegreeOfFreedomSequence;
    case DegreeOfFreedomID;
    case DegreeOfFreedomType;
    case TwoDMatingFeatureCoordinatesSequence;
    case ReferencedHPGLDocumentID;
    case TwoDMatingPoint;
    case TwoDMatingAxes;
    case TwoDDegreeOfFreedomSequence;
    case ThreeDDegreeOfFreedomAxis;
    case RangeOfFreedom;
    case ThreeDMatingPoint;
    case ThreeDMatingAxes;
    case TwoDDegreeOfFreedomAxis;
    case PlanningLandmarkPointSequence;
    case PlanningLandmarkLineSequence;
    case PlanningLandmarkPlaneSequence;
    case PlanningLandmarkID;
    case PlanningLandmarkDescription;
    case PlanningLandmarkIdentificationCodeSequence;
    case TwoDPointCoordinatesSequence;
    case TwoDPointCoordinates;
    case ThreeDPointCoordinates;
    case TwoDLineCoordinatesSequence;
    case TwoDLineCoordinates;
    case ThreeDLineCoordinates;
    case TwoDPlaneCoordinatesSequence;
    case TwoDPlaneIntersection;
    case ThreeDPlaneOrigin;
    case ThreeDPlaneNormal;
    case ModelModification;
    case ModelMirroring;
    case ModelUsageCodeSequence;
    case ModelGroupUID;
    case RelativeURIReferenceWithinEncapsulatedDocument;
    case AnnotationCoordinateType;
    case AnnotationGroupSequence;
    case AnnotationGroupUID;
    case AnnotationGroupLabel;
    case AnnotationGroupDescription;
    case AnnotationGroupGenerationType;
    case AnnotationGroupAlgorithmIdentificationSequence;
    case AnnotationPropertyCategoryCodeSequence;
    case AnnotationPropertyTypeCodeSequence;
    case AnnotationPropertyTypeModifierCodeSequence;
    case NumberOfAnnotations;
    case AnnotationAppliesToAllOpticalPaths;
    case ReferencedOpticalPathIdentifier;
    case AnnotationAppliesToAllZPlanes;
    case CommonZCoordinateValue;
    case AnnotationIndexList;
    case GraphicAnnotationSequence;
    case GraphicLayer;
    case BoundingBoxAnnotationUnits;
    case AnchorPointAnnotationUnits;
    case GraphicAnnotationUnits;
    case UnformattedTextValue;
    case TextObjectSequence;
    case GraphicObjectSequence;
    case BoundingBoxTopLeftHandCorner;
    case BoundingBoxBottomRightHandCorner;
    case BoundingBoxTextHorizontalJustification;
    case AnchorPoint;
    case AnchorPointVisibility;
    case GraphicDimensions;
    case NumberOfGraphicPoints;
    case GraphicData;
    case GraphicType;
    case GraphicFilled;
    case ImageHorizontalFlip;
    case ImageRotation;
    case DisplayedAreaTopLeftHandCorner;
    case DisplayedAreaBottomRightHandCorner;
    case DisplayedAreaSelectionSequence;
    case GraphicLayerSequence;
    case GraphicLayerOrder;
    case GraphicLayerRecommendedDisplayGrayscaleValue;
    case GraphicLayerDescription;
    case ContentLabel;
    case ContentDescription;
    case PresentationCreationDate;
    case PresentationCreationTime;
    case ContentCreatorName;
    case ContentCreatorIdentificationCodeSequence;
    case AlternateContentDescriptionSequence;
    case PresentationSizeMode;
    case PresentationPixelSpacing;
    case PresentationPixelAspectRatio;
    case PresentationPixelMagnificationRatio;
    case GraphicGroupLabel;
    case GraphicGroupDescription;
    case CompoundGraphicSequence;
    case CompoundGraphicInstanceID;
    case FontName;
    case FontNameType;
    case CSSFontName;
    case RotationAngle;
    case TextStyleSequence;
    case LineStyleSequence;
    case FillStyleSequence;
    case GraphicGroupSequence;
    case TextColorCIELabValue;
    case HorizontalAlignment;
    case VerticalAlignment;
    case ShadowStyle;
    case ShadowOffsetX;
    case ShadowOffsetY;
    case ShadowColorCIELabValue;
    case Underlined;
    case Bold;
    case Italic;
    case PatternOnColorCIELabValue;
    case PatternOffColorCIELabValue;
    case LineThickness;
    case LineDashingStyle;
    case LinePattern;
    case FillPattern;
    case FillMode;
    case ShadowOpacity;
    case GapLength;
    case DiameterOfVisibility;
    case RotationPoint;
    case TickAlignment;
    case ShowTickLabel;
    case TickLabelAlignment;
    case CompoundGraphicUnits;
    case PatternOnOpacity;
    case PatternOffOpacity;
    case MajorTicksSequence;
    case TickPosition;
    case TickLabel;
    case CompoundGraphicType;
    case GraphicGroupID;
    case ShapeType;
    case RegistrationSequence;
    case MatrixRegistrationSequence;
    case MatrixSequence;
    case FrameOfReferenceToDisplayedCoordinateSystemTransformationMatrix;
    case FrameOfReferenceTransformationMatrixType;
    case RegistrationTypeCodeSequence;
    case FiducialDescription;
    case FiducialIdentifier;
    case FiducialIdentifierCodeSequence;
    case ContourUncertaintyRadius;
    case UsedFiducialsSequence;
    case UsedRTStructureSetROISequence;
    case GraphicCoordinatesDataSequence;
    case FiducialUID;
    case ReferencedFiducialUID;
    case FiducialSetSequence;
    case FiducialSequence;
    case FiducialsPropertyCategoryCodeSequence;
    case GraphicLayerRecommendedDisplayCIELabValue;
    case BlendingSequence;
    case RelativeOpacity;
    case ReferencedSpatialRegistrationSequence;
    case BlendingPosition;
    case PresentationDisplayCollectionUID;
    case PresentationSequenceCollectionUID;
    case PresentationSequencePositionIndex;
    case RenderedImageReferenceSequence;
    case VolumetricPresentationStateInputSequence;
    case PresentationInputType;
    case InputSequencePositionIndex;
    case Crop;
    case CroppingSpecificationIndex;
    case VolumetricPresentationInputNumber;
    case ImageVolumeGeometry;
    case VolumetricPresentationInputSetUID;
    case VolumetricPresentationInputSetSequence;
    case GlobalCrop;
    case GlobalCroppingSpecificationIndex;
    case RenderingMethod;
    case VolumeCroppingSequence;
    case VolumeCroppingMethod;
    case BoundingBoxCrop;
    case ObliqueCroppingPlaneSequence;
    case Plane;
    case PlaneNormal;
    case CroppingSpecificationNumber;
    case MultiPlanarReconstructionStyle;
    case MPRThicknessType;
    case MPRSlabThickness;
    case MPRTopLeftHandCorner;
    case MPRViewWidthDirection;
    case MPRViewWidth;
    case NumberOfVolumetricCurvePoints;
    case VolumetricCurvePoints;
    case MPRViewHeightDirection;
    case MPRViewHeight;
    case RenderProjection;
    case ViewpointPosition;
    case ViewpointLookAtPoint;
    case ViewpointUpDirection;
    case RenderFieldOfView;
    case SamplingStepSize;
    case ShadingStyle;
    case AmbientReflectionIntensity;
    case LightDirection;
    case DiffuseReflectionIntensity;
    case SpecularReflectionIntensity;
    case Shininess;
    case PresentationStateClassificationComponentSequence;
    case ComponentType;
    case ComponentInputSequence;
    case VolumetricPresentationInputIndex;
    case PresentationStateCompositorComponentSequence;
    case WeightingTransferFunctionSequence;
    case VolumetricAnnotationSequence;
    case ReferencedStructuredContextSequence;
    case ReferencedContentItem;
    case VolumetricPresentationInputAnnotationSequence;
    case AnnotationClipping;
    case PresentationAnimationStyle;
    case RecommendedAnimationRate;
    case AnimationCurveSequence;
    case AnimationStepSize;
    case SwivelRange;
    case VolumetricCurveUpDirections;
    case VolumeStreamSequence;
    case RGBATransferFunctionDescription;
    case AdvancedBlendingSequence;
    case BlendingInputNumber;
    case BlendingDisplayInputSequence;
    case BlendingDisplaySequence;
    case BlendingMode;
    case TimeSeriesBlending;
    case GeometryForDisplay;
    case ThresholdSequence;
    case ThresholdValueSequence;
    case ThresholdType;
    case ThresholdValue;
    case HangingProtocolName;
    case HangingProtocolDescription;
    case HangingProtocolLevel;
    case HangingProtocolCreator;
    case HangingProtocolCreationDateTime;
    case HangingProtocolDefinitionSequence;
    case HangingProtocolUserIdentificationCodeSequence;
    case HangingProtocolUserGroupName;
    case SourceHangingProtocolSequence;
    case NumberOfPriorsReferenced;
    case ImageSetsSequence;
    case ImageSetSelectorSequence;
    case ImageSetSelectorUsageFlag;
    case SelectorAttribute;
    case SelectorValueNumber;
    case TimeBasedImageSetsSequence;
    case ImageSetNumber;
    case ImageSetSelectorCategory;
    case RelativeTime;
    case RelativeTimeUnits;
    case AbstractPriorValue;
    case AbstractPriorCodeSequence;
    case ImageSetLabel;
    case SelectorAttributeVR;
    case SelectorSequencePointer;
    case SelectorSequencePointerPrivateCreator;
    case SelectorAttributePrivateCreator;
    case SelectorAEValue;
    case SelectorASValue;
    case SelectorATValue;
    case SelectorDAValue;
    case SelectorCSValue;
    case SelectorDTValue;
    case SelectorISValue;
    case SelectorOBValue;
    case SelectorLOValue;
    case SelectorOFValue;
    case SelectorLTValue;
    case SelectorOWValue;
    case SelectorPNValue;
    case SelectorTMValue;
    case SelectorSHValue;
    case SelectorUNValue;
    case SelectorSTValue;
    case SelectorUCValue;
    case SelectorUTValue;
    case SelectorURValue;
    case SelectorDSValue;
    case SelectorODValue;
    case SelectorFDValue;
    case SelectorOLValue;
    case SelectorFLValue;
    case SelectorULValue;
    case SelectorUSValue;
    case SelectorSLValue;
    case SelectorSSValue;
    case SelectorUIValue;
    case SelectorCodeSequenceValue;
    case SelectorOVValue;
    case SelectorSVValue;
    case SelectorUVValue;
    case NumberOfScreens;
    case NominalScreenDefinitionSequence;
    case NumberOfVerticalPixels;
    case NumberOfHorizontalPixels;
    case DisplayEnvironmentSpatialPosition;
    case ScreenMinimumGrayscaleBitDepth;
    case ScreenMinimumColorBitDepth;
    case ApplicationMaximumRepaintTime;
    case DisplaySetsSequence;
    case DisplaySetNumber;
    case DisplaySetLabel;
    case DisplaySetPresentationGroup;
    case DisplaySetPresentationGroupDescription;
    case PartialDataDisplayHandling;
    case SynchronizedScrollingSequence;
    case DisplaySetScrollingGroup;
    case NavigationIndicatorSequence;
    case NavigationDisplaySet;
    case ReferenceDisplaySets;
    case ImageBoxesSequence;
    case ImageBoxNumber;
    case ImageBoxLayoutType;
    case ImageBoxTileHorizontalDimension;
    case ImageBoxTileVerticalDimension;
    case ImageBoxScrollDirection;
    case ImageBoxSmallScrollType;
    case ImageBoxSmallScrollAmount;
    case ImageBoxLargeScrollType;
    case ImageBoxLargeScrollAmount;
    case ImageBoxOverlapPriority;
    case CineRelativeToRealTime;
    case FilterOperationsSequence;
    case FilterByCategory;
    case FilterByAttributePresence;
    case FilterByOperator;
    case StructuredDisplayBackgroundCIELabValue;
    case EmptyImageBoxCIELabValue;
    case StructuredDisplayImageBoxSequence;
    case StructuredDisplayTextBoxSequence;
    case ReferencedFirstFrameSequence;
    case ImageBoxSynchronizationSequence;
    case SynchronizedImageBoxList;
    case TypeOfSynchronization;
    case BlendingOperationType;
    case ReformattingOperationType;
    case ReformattingThickness;
    case ReformattingInterval;
    case ReformattingOperationInitialViewDirection;
    case ThreeDRenderingType;
    case SortingOperationsSequence;
    case SortByCategory;
    case SortingDirection;
    case DisplaySetPatientOrientation;
    case VOIType;
    case PseudoColorType;
    case PseudoColorPaletteInstanceReferenceSequence;
    case ShowGrayscaleInverted;
    case ShowImageTrueSizeFlag;
    case ShowGraphicAnnotationFlag;
    case ShowPatientDemographicsFlag;
    case ShowAcquisitionTechniquesFlag;
    case DisplaySetHorizontalJustification;
    case DisplaySetVerticalJustification;
    case ContinuationStartMeterset;
    case ContinuationEndMeterset;
    case ProcedureStepState;
    case ProcedureStepProgressInformationSequence;
    case ProcedureStepProgress;
    case ProcedureStepProgressDescription;
    case ProcedureStepProgressParametersSequence;
    case ProcedureStepCommunicationsURISequence;
    case ContactURI;
    case ContactDisplayName;
    case ProcedureStepDiscontinuationReasonCodeSequence;
    case BeamTaskSequence;
    case BeamTaskType;
    case AutosequenceFlag;
    case TableTopVerticalAdjustedPosition;
    case TableTopLongitudinalAdjustedPosition;
    case TableTopLateralAdjustedPosition;
    case PatientSupportAdjustedAngle;
    case TableTopEccentricAdjustedAngle;
    case TableTopPitchAdjustedAngle;
    case TableTopRollAdjustedAngle;
    case DeliveryVerificationImageSequence;
    case VerificationImageTiming;
    case DoubleExposureFlag;
    case DoubleExposureOrdering;
    case RelatedReferenceRTImageSequence;
    case GeneralMachineVerificationSequence;
    case ConventionalMachineVerificationSequence;
    case IonMachineVerificationSequence;
    case FailedAttributesSequence;
    case OverriddenAttributesSequence;
    case ConventionalControlPointVerificationSequence;
    case IonControlPointVerificationSequence;
    case AttributeOccurrenceSequence;
    case AttributeOccurrencePointer;
    case AttributeItemSelector;
    case AttributeOccurrencePrivateCreator;
    case SelectorSequencePointerItems;
    case ScheduledProcedureStepPriority;
    case WorklistLabel;
    case ProcedureStepLabel;
    case ScheduledProcessingParametersSequence;
    case PerformedProcessingParametersSequence;
    case UnifiedProcedureStepPerformedProcedureSequence;
    case ReplacedProcedureStepSequence;
    case DeletionLock;
    case ReceivingAE;
    case RequestingAE;
    case ReasonForCancellation;
    case SCPStatus;
    case SubscriptionListStatus;
    case UnifiedProcedureStepListStatus;
    case BeamOrderIndex;
    case DoubleExposureMeterset;
    case DoubleExposureFieldDelta;
    case BrachyTaskSequence;
    case ContinuationStartTotalReferenceAirKerma;
    case ContinuationEndTotalReferenceAirKerma;
    case ContinuationPulseNumber;
    case ChannelDeliveryOrderSequence;
    case ReferencedChannelNumber;
    case StartCumulativeTimeWeight;
    case EndCumulativeTimeWeight;
    case OmittedChannelSequence;
    case ReasonForChannelOmission;
    case ReasonForChannelOmissionDescription;
    case ChannelDeliveryOrderIndex;
    case ChannelDeliveryContinuationSequence;
    case OmittedApplicationSetupSequence;
    case ImplantAssemblyTemplateName;
    case ImplantAssemblyTemplateIssuer;
    case ImplantAssemblyTemplateVersion;
    case ReplacedImplantAssemblyTemplateSequence;
    case ImplantAssemblyTemplateType;
    case OriginalImplantAssemblyTemplateSequence;
    case DerivationImplantAssemblyTemplateSequence;
    case ImplantAssemblyTemplateTargetAnatomySequence;
    case ProcedureTypeCodeSequence;
    case SurgicalTechnique;
    case ComponentTypesSequence;
    case ComponentTypeCodeSequence;
    case ExclusiveComponentType;
    case MandatoryComponentType;
    case ComponentSequence;
    case ComponentID;
    case ComponentAssemblySequence;
    case Component1ReferencedID;
    case Component1ReferencedMatingFeatureSetID;
    case Component1ReferencedMatingFeatureID;
    case Component2ReferencedID;
    case Component2ReferencedMatingFeatureSetID;
    case Component2ReferencedMatingFeatureID;
    case ImplantTemplateGroupName;
    case ImplantTemplateGroupDescription;
    case ImplantTemplateGroupIssuer;
    case ImplantTemplateGroupVersion;
    case ReplacedImplantTemplateGroupSequence;
    case ImplantTemplateGroupTargetAnatomySequence;
    case ImplantTemplateGroupMembersSequence;
    case ImplantTemplateGroupMemberID;
    case ThreeDImplantTemplateGroupMemberMatchingPoint;
    case ThreeDImplantTemplateGroupMemberMatchingAxes;
    case ImplantTemplateGroupMemberMatching2DCoordinatesSequence;
    case TwoDImplantTemplateGroupMemberMatchingPoint;
    case TwoDImplantTemplateGroupMemberMatchingAxes;
    case ImplantTemplateGroupVariationDimensionSequence;
    case ImplantTemplateGroupVariationDimensionName;
    case ImplantTemplateGroupVariationDimensionRankSequence;
    case ReferencedImplantTemplateGroupMemberID;
    case ImplantTemplateGroupVariationDimensionRank;
    case SurfaceScanAcquisitionTypeCodeSequence;
    case SurfaceScanModeCodeSequence;
    case RegistrationMethodCodeSequence;
    case ShotDurationTime;
    case ShotOffsetTime;
    case SurfacePointPresentationValueData;
    case SurfacePointColorCIELabValueData;
    case UVMappingSequence;
    case TextureLabel;
    case UValueData;
    case VValueData;
    case ReferencedTextureSequence;
    case ReferencedSurfaceDataSequence;
    case AssessmentSummary;
    case AssessmentSummaryDescription;
    case AssessedSOPInstanceSequence;
    case ReferencedComparisonSOPInstanceSequence;
    case NumberOfAssessmentObservations;
    case AssessmentObservationsSequence;
    case ObservationSignificance;
    case ObservationDescription;
    case StructuredConstraintObservationSequence;
    case AssessedAttributeValueSequence;
    case AssessmentSetID;
    case AssessmentRequesterSequence;
    case SelectorAttributeName;
    case SelectorAttributeKeyword;
    case AssessmentTypeCodeSequence;
    case ObservationBasisCodeSequence;
    case AssessmentLabel;
    case ConstraintType;
    case SpecificationSelectionGuidance;
    case ConstraintValueSequence;
    case RecommendedDefaultValueSequence;
    case ConstraintViolationSignificance;
    case ConstraintViolationCondition;
    case ModifiableConstraintFlag;
    case StorageMediaFileSetID;
    case StorageMediaFileSetUID;
    case IconImageSequence;
    case SOPInstanceStatus;
    case SOPAuthorizationDateTime;
    case SOPAuthorizationComment;
    case AuthorizationEquipmentCertificationNumber;
    case MACIDNumber;
    case MACCalculationTransferSyntaxUID;
    case MACAlgorithm;
    case DataElementsSigned;
    case DigitalSignatureUID;
    case DigitalSignatureDateTime;
    case CertificateType;
    case CertificateOfSigner;
    case Signature;
    case CertifiedTimestampType;
    case CertifiedTimestamp;
    case DigitalSignaturePurposeCodeSequence;
    case ReferencedDigitalSignatureSequence;
    case ReferencedSOPInstanceMACSequence;
    case MAC;
    case EncryptedAttributesSequence;
    case EncryptedContentTransferSyntaxUID;
    case EncryptedContent;
    case ModifiedAttributesSequence;
    case NonconformingModifiedAttributesSequence;
    case NonconformingDataElementValue;
    case OriginalAttributesSequence;
    case AttributeModificationDateTime;
    case ModifyingSystem;
    case SourceOfPreviousValues;
    case ReasonForTheAttributeModification;
    case InstanceOriginStatus;
    case NumberOfCopies;
    case PrinterConfigurationSequence;
    case PrintPriority;
    case MediumType;
    case FilmDestination;
    case FilmSessionLabel;
    case MemoryAllocation;
    case MaximumMemoryAllocation;
    case MemoryBitDepth;
    case PrintingBitDepth;
    case MediaInstalledSequence;
    case OtherMediaAvailableSequence;
    case SupportedImageDisplayFormatsSequence;
    case ReferencedFilmBoxSequence;
    case ImageDisplayFormat;
    case AnnotationDisplayFormatID;
    case FilmOrientation;
    case FilmSizeID;
    case PrinterResolutionID;
    case DefaultPrinterResolutionID;
    case MagnificationType;
    case SmoothingType;
    case DefaultMagnificationType;
    case OtherMagnificationTypesAvailable;
    case DefaultSmoothingType;
    case OtherSmoothingTypesAvailable;
    case BorderDensity;
    case EmptyImageDensity;
    case MinDensity;
    case MaxDensity;
    case Trim;
    case ConfigurationInformation;
    case ConfigurationInformationDescription;
    case MaximumCollatedFilms;
    case Illumination;
    case ReflectedAmbientLight;
    case PrinterPixelSpacing;
    case ReferencedFilmSessionSequence;
    case ReferencedImageBoxSequence;
    case ReferencedBasicAnnotationBoxSequence;
    case ImageBoxPosition;
    case Polarity;
    case RequestedImageSize;
    case RequestedDecimateCropBehavior;
    case RequestedResolutionID;
    case RequestedImageSizeFlag;
    case DecimateCropResult;
    case BasicGrayscaleImageSequence;
    case BasicColorImageSequence;
    case AnnotationPosition;
    case TextString;
    case PresentationLUTSequence;
    case PresentationLUTShape;
    case ReferencedPresentationLUTSequence;
    case ExecutionStatus;
    case ExecutionStatusInfo;
    case CreationDate;
    case CreationTime;
    case Originator;
    case DestinationAE;
    case OwnerID;
    case NumberOfFilms;
    case PrinterStatus;
    case PrinterStatusInfo;
    case PrinterName;
    case ProposedStudySequence;
    case OriginalImageSequence;
    case LabelUsingInformationExtractedFromInstances;
    case LabelText;
    case LabelStyleSelection;
    case MediaDisposition;
    case BarcodeValue;
    case BarcodeSymbology;
    case AllowMediaSplitting;
    case IncludeNonDICOMObjects;
    case IncludeDisplayApplication;
    case PreserveCompositeInstancesAfterMediaCreation;
    case TotalNumberOfPiecesOfMediaCreated;
    case RequestedMediaApplicationProfile;
    case ReferencedStorageMediaSequence;
    case FailureAttributes;
    case AllowLossyCompression;
    case RequestPriority;
    case RTImageLabel;
    case RTImageName;
    case RTImageDescription;
    case ReportedValuesOrigin;
    case RTImagePlane;
    case XRayImageReceptorTranslation;
    case XRayImageReceptorAngle;
    case RTImageOrientation;
    case ImagePlanePixelSpacing;
    case RTImagePosition;
    case RadiationMachineName;
    case RadiationMachineSAD;
    case RadiationMachineSSD;
    case RTImageSID;
    case SourceToReferenceObjectDistance;
    case FractionNumber;
    case ExposureSequence;
    case MetersetExposure;
    case DiaphragmPosition;
    case FluenceMapSequence;
    case FluenceDataSource;
    case FluenceDataScale;
    case PrimaryFluenceModeSequence;
    case FluenceMode;
    case FluenceModeID;
    case SelectedFrameNumber;
    case SelectedFrameFunctionalGroupsSequence;
    case RTImageFrameGeneralContentSequence;
    case RTImageFrameContextSequence;
    case RTImageScopeSequence;
    case BeamModifierCoordinatesPresenceFlag;
    case StartCumulativeMeterset;
    case StopCumulativeMeterset;
    case RTAcquisitionPatientPositionSequence;
    case RTImageFrameImagingDevicePositionSequence;
    case RTImageFramekVRadiationAcquisitionSequence;
    case RTImageFrameMVRadiationAcquisitionSequence;
    case RTImageFrameRadiationAcquisitionSequence;
    case ImagingSourcePositionSequence;
    case ImageReceptorPositionSequence;
    case DevicePositionToEquipmentMappingMatrix;
    case DevicePositionParameterSequence;
    case ImagingSourceLocationSpecificationType;
    case ImagingDeviceLocationMatrixSequence;
    case ImagingDeviceLocationParameterSequence;
    case ImagingApertureSequence;
    case ImagingApertureSpecificationType;
    case NumberOfAcquisitionDevices;
    case AcquisitionDeviceSequence;
    case AcquisitionTaskSequence;
    case AcquisitionTaskWorkitemCodeSequence;
    case AcquisitionSubtaskSequence;
    case SubtaskWorkitemCodeSequence;
    case AcquisitionTaskIndex;
    case AcquisitionSubtaskIndex;
    case ReferencedBaselineParametersRTRadiationInstanceSequence;
    case PositionAcquisitionTemplateIdentificationSequence;
    case PositionAcquisitionTemplateID;
    case PositionAcquisitionTemplateName;
    case PositionAcquisitionTemplateCodeSequence;
    case PositionAcquisitionTemplateDescription;
    case AcquisitionTaskApplicabilitySequence;
    case ProjectionImagingAcquisitionParameterSequence;
    case CTImagingAcquisitionParameterSequence;
    case KVImagingGenerationParametersSequence;
    case MVImagingGenerationParametersSequence;
    case AcquisitionSignalType;
    case AcquisitionMethod;
    case ScanStartPositionSequence;
    case ScanStopPositionSequence;
    case ImagingSourceToBeamModifierDefinitionPlaneDistance;
    case ScanArcType;
    case DetectorPositioningType;
    case AdditionalRTAccessoryDeviceSequence;
    case DeviceSpecificAcquisitionParameterSequence;
    case ReferencedPositionReferenceInstanceSequence;
    case EnergyDerivationCodeSequence;
    case MaximumCumulativeMetersetExposure;
    case AcquisitionInitiationSequence;
    case RTConeBeamImagingGeometrySequence;
    case DVHType;
    case DoseUnits;
    case DoseType;
    case SpatialTransformOfDose;
    case DoseComment;
    case NormalizationPoint;
    case DoseSummationType;
    case GridFrameOffsetVector;
    case DoseGridScaling;
    case DoseValue;
    case TissueHeterogeneityCorrection;
    case RecommendedIsodoseLevelSequence;
    case DoseUnitCodeSequence;
    case RTDoseInterpretedTypeCodeSequence;
    case RTDoseInterpretedTypeCodeModifierSequence;
    case DoseRadiobiologicalInterpretationSequence;
    case RTDoseIntentCodeSequence;
    case DVHNormalizationPoint;
    case DVHNormalizationDoseValue;
    case DVHSequence;
    case DVHDoseScaling;
    case DVHVolumeUnits;
    case DVHNumberOfBins;
    case DVHData;
    case DVHReferencedROISequence;
    case DVHROIContributionType;
    case DVHMinimumDose;
    case DVHMaximumDose;
    case DVHMeanDose;
    case DoseCalculationModelSequence;
    case DoseCalculationAlgorithmSequence;
    case CommissioningStatus;
    case DoseCalculationModelParameterSequence;
    case DoseDepositionCalculationMedium;
    case StructureSetLabel;
    case StructureSetName;
    case StructureSetDescription;
    case StructureSetDate;
    case StructureSetTime;
    case ReferencedFrameOfReferenceSequence;
    case RTReferencedStudySequence;
    case RTReferencedSeriesSequence;
    case ContourImageSequence;
    case PredecessorStructureSetSequence;
    case StructureSetROISequence;
    case ROINumber;
    case ReferencedFrameOfReferenceUID;
    case ROIName;
    case ROIDescription;
    case ROIDisplayColor;
    case ROIVolume;
    case ROIDateTime;
    case ROIObservationDateTime;
    case RTRelatedROISequence;
    case RTROIRelationship;
    case ROIGenerationAlgorithm;
    case ROIDerivationAlgorithmIdentificationSequence;
    case ROIGenerationDescription;
    case ROIContourSequence;
    case ContourSequence;
    case ContourGeometricType;
    case NumberOfContourPoints;
    case ContourNumber;
    case SourcePixelPlanesCharacteristicsSequence;
    case SourceSeriesSequence;
    case SourceSeriesInformationSequence;
    case ROICreatorSequence;
    case ROIInterpreterSequence;
    case ROIObservationContextCodeSequence;
    case ContourData;
    case RTROIObservationsSequence;
    case ObservationNumber;
    case ReferencedROINumber;
    case RTROIIdentificationCodeSequence;
    case RelatedRTROIObservationsSequence;
    case RTROIInterpretedType;
    case ROIInterpreter;
    case ROIPhysicalPropertiesSequence;
    case ROIPhysicalProperty;
    case ROIPhysicalPropertyValue;
    case ROIElementalCompositionSequence;
    case ROIElementalCompositionAtomicNumber;
    case ROIElementalCompositionAtomicMassFraction;
    case FrameOfReferenceTransformationMatrix;
    case FrameOfReferenceTransformationComment;
    case PatientLocationCoordinatesSequence;
    case PatientLocationCoordinatesCodeSequence;
    case PatientSupportPositionSequence;
    case MeasuredDoseReferenceSequence;
    case MeasuredDoseDescription;
    case MeasuredDoseType;
    case MeasuredDoseValue;
    case TreatmentSessionBeamSequence;
    case TreatmentSessionIonBeamSequence;
    case CurrentFractionNumber;
    case TreatmentControlPointDate;
    case TreatmentControlPointTime;
    case TreatmentTerminationStatus;
    case TreatmentVerificationStatus;
    case ReferencedTreatmentRecordSequence;
    case SpecifiedPrimaryMeterset;
    case SpecifiedSecondaryMeterset;
    case DeliveredPrimaryMeterset;
    case DeliveredSecondaryMeterset;
    case SpecifiedTreatmentTime;
    case DeliveredTreatmentTime;
    case ControlPointDeliverySequence;
    case IonControlPointDeliverySequence;
    case SpecifiedMeterset;
    case DeliveredMeterset;
    case MetersetRateSet;
    case MetersetRateDelivered;
    case ScanSpotMetersetsDelivered;
    case DoseRateDelivered;
    case TreatmentSummaryCalculatedDoseReferenceSequence;
    case CumulativeDoseToDoseReference;
    case FirstTreatmentDate;
    case MostRecentTreatmentDate;
    case NumberOfFractionsDelivered;
    case OverrideSequence;
    case ParameterSequencePointer;
    case OverrideParameterPointer;
    case ParameterItemIndex;
    case MeasuredDoseReferenceNumber;
    case ParameterPointer;
    case OverrideReason;
    case ParameterValueNumber;
    case CorrectedParameterSequence;
    case CorrectionValue;
    case CalculatedDoseReferenceSequence;
    case CalculatedDoseReferenceNumber;
    case CalculatedDoseReferenceDescription;
    case CalculatedDoseReferenceDoseValue;
    case StartMeterset;
    case EndMeterset;
    case ReferencedMeasuredDoseReferenceSequence;
    case ReferencedMeasuredDoseReferenceNumber;
    case ReferencedCalculatedDoseReferenceSequence;
    case ReferencedCalculatedDoseReferenceNumber;
    case BeamLimitingDeviceLeafPairsSequence;
    case EnhancedRTBeamLimitingDeviceSequence;
    case EnhancedRTBeamLimitingOpeningSequence;
    case EnhancedRTBeamLimitingDeviceDefinitionFlag;
    case ParallelRTBeamDelimiterOpeningExtents;
    case RecordedWedgeSequence;
    case RecordedCompensatorSequence;
    case RecordedBlockSequence;
    case RecordedBlockSlabSequence;
    case TreatmentSummaryMeasuredDoseReferenceSequence;
    case RecordedSnoutSequence;
    case RecordedRangeShifterSequence;
    case RecordedLateralSpreadingDeviceSequence;
    case RecordedRangeModulatorSequence;
    case RecordedSourceSequence;
    case SourceSerialNumber;
    case TreatmentSessionApplicationSetupSequence;
    case ApplicationSetupCheck;
    case RecordedBrachyAccessoryDeviceSequence;
    case ReferencedBrachyAccessoryDeviceNumber;
    case RecordedChannelSequence;
    case SpecifiedChannelTotalTime;
    case DeliveredChannelTotalTime;
    case SpecifiedNumberOfPulses;
    case DeliveredNumberOfPulses;
    case SpecifiedPulseRepetitionInterval;
    case DeliveredPulseRepetitionInterval;
    case RecordedSourceApplicatorSequence;
    case ReferencedSourceApplicatorNumber;
    case RecordedChannelShieldSequence;
    case ReferencedChannelShieldNumber;
    case BrachyControlPointDeliveredSequence;
    case SafePositionExitDate;
    case SafePositionExitTime;
    case SafePositionReturnDate;
    case SafePositionReturnTime;
    case PulseSpecificBrachyControlPointDeliveredSequence;
    case PulseNumber;
    case BrachyPulseControlPointDeliveredSequence;
    case CurrentTreatmentStatus;
    case TreatmentStatusComment;
    case FractionGroupSummarySequence;
    case ReferencedFractionNumber;
    case FractionGroupType;
    case BeamStopperPosition;
    case FractionStatusSummarySequence;
    case TreatmentDate;
    case TreatmentTime;
    case RTPlanLabel;
    case RTPlanName;
    case RTPlanDescription;
    case RTPlanDate;
    case RTPlanTime;
    case TreatmentProtocols;
    case PlanIntent;
    case RTPlanGeometry;
    case PrescriptionDescription;
    case DoseReferenceSequence;
    case DoseReferenceNumber;
    case DoseReferenceUID;
    case DoseReferenceStructureType;
    case NominalBeamEnergyUnit;
    case DoseReferenceDescription;
    case DoseReferencePointCoordinates;
    case NominalPriorDose;
    case DoseReferenceType;
    case ConstraintWeight;
    case DeliveryWarningDose;
    case DeliveryMaximumDose;
    case TargetMinimumDose;
    case TargetPrescriptionDose;
    case TargetMaximumDose;
    case TargetUnderdoseVolumeFraction;
    case OrganAtRiskFullVolumeDose;
    case OrganAtRiskLimitDose;
    case OrganAtRiskMaximumDose;
    case OrganAtRiskOverdoseVolumeFraction;
    case ToleranceTableSequence;
    case ToleranceTableNumber;
    case ToleranceTableLabel;
    case GantryAngleTolerance;
    case BeamLimitingDeviceAngleTolerance;
    case BeamLimitingDeviceToleranceSequence;
    case BeamLimitingDevicePositionTolerance;
    case SnoutPositionTolerance;
    case PatientSupportAngleTolerance;
    case TableTopEccentricAngleTolerance;
    case TableTopPitchAngleTolerance;
    case TableTopRollAngleTolerance;
    case TableTopVerticalPositionTolerance;
    case TableTopLongitudinalPositionTolerance;
    case TableTopLateralPositionTolerance;
    case TableTopPositionAlignmentUID;
    case RTPlanRelationship;
    case FractionGroupSequence;
    case FractionGroupNumber;
    case FractionGroupDescription;
    case NumberOfFractionsPlanned;
    case NumberOfFractionPatternDigitsPerDay;
    case RepeatFractionCycleLength;
    case FractionPattern;
    case NumberOfBeams;
    case ReferencedDoseReferenceUID;
    case BeamDose;
    case BeamMeterset;
    case BeamDosePointDepth;
    case BeamDosePointEquivalentDepth;
    case BeamDosePointSSD;
    case BeamDoseMeaning;
    case BeamDoseVerificationControlPointSequence;
    case BeamDoseType;
    case AlternateBeamDose;
    case AlternateBeamDoseType;
    case DepthValueAveragingFlag;
    case BeamDosePointSourceToExternalContourDistance;
    case NumberOfBrachyApplicationSetups;
    case BrachyApplicationSetupDoseSpecificationPoint;
    case BrachyApplicationSetupDose;
    case BeamSequence;
    case TreatmentMachineName;
    case PrimaryDosimeterUnit;
    case SourceAxisDistance;
    case BeamLimitingDeviceSequence;
    case RTBeamLimitingDeviceType;
    case SourceToBeamLimitingDeviceDistance;
    case IsocenterToBeamLimitingDeviceDistance;
    case NumberOfLeafJawPairs;
    case LeafPositionBoundaries;
    case BeamNumber;
    case BeamName;
    case BeamDescription;
    case BeamType;
    case BeamDeliveryDurationLimit;
    case RadiationType;
    case HighDoseTechniqueType;
    case ReferenceImageNumber;
    case PlannedVerificationImageSequence;
    case ImagingDeviceSpecificAcquisitionParameters;
    case TreatmentDeliveryType;
    case NumberOfWedges;
    case WedgeSequence;
    case WedgeNumber;
    case WedgeType;
    case WedgeID;
    case WedgeAngle;
    case WedgeFactor;
    case TotalWedgeTrayWaterEquivalentThickness;
    case WedgeOrientation;
    case IsocenterToWedgeTrayDistance;
    case SourceToWedgeTrayDistance;
    case WedgeThinEdgePosition;
    case BolusID;
    case BolusDescription;
    case EffectiveWedgeAngle;
    case NumberOfCompensators;
    case MaterialID;
    case TotalCompensatorTrayFactor;
    case CompensatorSequence;
    case CompensatorNumber;
    case CompensatorID;
    case SourceToCompensatorTrayDistance;
    case CompensatorRows;
    case CompensatorColumns;
    case CompensatorPixelSpacing;
    case CompensatorPosition;
    case CompensatorTransmissionData;
    case CompensatorThicknessData;
    case NumberOfBoli;
    case CompensatorType;
    case CompensatorTrayID;
    case NumberOfBlocks;
    case TotalBlockTrayFactor;
    case TotalBlockTrayWaterEquivalentThickness;
    case BlockSequence;
    case BlockTrayID;
    case SourceToBlockTrayDistance;
    case IsocenterToBlockTrayDistance;
    case BlockType;
    case AccessoryCode;
    case BlockDivergence;
    case BlockMountingPosition;
    case BlockNumber;
    case BlockName;
    case BlockThickness;
    case BlockTransmission;
    case BlockNumberOfPoints;
    case BlockData;
    case ApplicatorSequence;
    case ApplicatorID;
    case ApplicatorType;
    case ApplicatorDescription;
    case CumulativeDoseReferenceCoefficient;
    case FinalCumulativeMetersetWeight;
    case NumberOfControlPoints;
    case ControlPointSequence;
    case ControlPointIndex;
    case NominalBeamEnergy;
    case DoseRateSet;
    case WedgePositionSequence;
    case WedgePosition;
    case BeamLimitingDevicePositionSequence;
    case LeafJawPositions;
    case GantryAngle;
    case GantryRotationDirection;
    case BeamLimitingDeviceAngle;
    case BeamLimitingDeviceRotationDirection;
    case PatientSupportAngle;
    case PatientSupportRotationDirection;
    case TableTopEccentricAxisDistance;
    case TableTopEccentricAngle;
    case TableTopEccentricRotationDirection;
    case TableTopVerticalPosition;
    case TableTopLongitudinalPosition;
    case TableTopLateralPosition;
    case IsocenterPosition;
    case SurfaceEntryPoint;
    case SourceToSurfaceDistance;
    case AverageBeamDosePointSourceToExternalContourDistance;
    case SourceToExternalContourDistance;
    case ExternalContourEntryPoint;
    case CumulativeMetersetWeight;
    case TableTopPitchAngle;
    case TableTopPitchRotationDirection;
    case TableTopRollAngle;
    case TableTopRollRotationDirection;
    case HeadFixationAngle;
    case GantryPitchAngle;
    case GantryPitchRotationDirection;
    case GantryPitchAngleTolerance;
    case FixationEye;
    case ChairHeadFramePosition;
    case HeadFixationAngleTolerance;
    case ChairHeadFramePositionTolerance;
    case FixationLightAzimuthalAngleTolerance;
    case FixationLightPolarAngleTolerance;
    case PatientSetupSequence;
    case PatientSetupNumber;
    case PatientSetupLabel;
    case PatientAdditionalPosition;
    case FixationDeviceSequence;
    case FixationDeviceType;
    case FixationDeviceLabel;
    case FixationDeviceDescription;
    case FixationDevicePosition;
    case FixationDevicePitchAngle;
    case FixationDeviceRollAngle;
    case ShieldingDeviceSequence;
    case ShieldingDeviceType;
    case ShieldingDeviceLabel;
    case ShieldingDeviceDescription;
    case ShieldingDevicePosition;
    case SetupTechnique;
    case SetupTechniqueDescription;
    case SetupDeviceSequence;
    case SetupDeviceType;
    case SetupDeviceLabel;
    case SetupDeviceDescription;
    case SetupDeviceParameter;
    case SetupReferenceDescription;
    case TableTopVerticalSetupDisplacement;
    case TableTopLongitudinalSetupDisplacement;
    case TableTopLateralSetupDisplacement;
    case BrachyTreatmentTechnique;
    case BrachyTreatmentType;
    case TreatmentMachineSequence;
    case SourceSequence;
    case SourceNumber;
    case SourceType;
    case SourceManufacturer;
    case ActiveSourceDiameter;
    case ActiveSourceLength;
    case SourceModelID;
    case SourceDescription;
    case SourceEncapsulationNominalThickness;
    case SourceEncapsulationNominalTransmission;
    case SourceIsotopeName;
    case SourceIsotopeHalfLife;
    case SourceStrengthUnits;
    case ReferenceAirKermaRate;
    case SourceStrength;
    case SourceStrengthReferenceDate;
    case SourceStrengthReferenceTime;
    case ApplicationSetupSequence;
    case ApplicationSetupType;
    case ApplicationSetupNumber;
    case ApplicationSetupName;
    case ApplicationSetupManufacturer;
    case TemplateNumber;
    case TemplateType;
    case TemplateName;
    case TotalReferenceAirKerma;
    case BrachyAccessoryDeviceSequence;
    case BrachyAccessoryDeviceNumber;
    case BrachyAccessoryDeviceID;
    case BrachyAccessoryDeviceType;
    case BrachyAccessoryDeviceName;
    case BrachyAccessoryDeviceNominalThickness;
    case BrachyAccessoryDeviceNominalTransmission;
    case ChannelEffectiveLength;
    case ChannelInnerLength;
    case AfterloaderChannelID;
    case SourceApplicatorTipLength;
    case ChannelSequence;
    case ChannelNumber;
    case ChannelLength;
    case ChannelTotalTime;
    case SourceMovementType;
    case NumberOfPulses;
    case PulseRepetitionInterval;
    case SourceApplicatorNumber;
    case SourceApplicatorID;
    case SourceApplicatorType;
    case SourceApplicatorName;
    case SourceApplicatorLength;
    case SourceApplicatorManufacturer;
    case SourceApplicatorWallNominalThickness;
    case SourceApplicatorWallNominalTransmission;
    case SourceApplicatorStepSize;
    case ApplicatorShapeReferencedROINumber;
    case TransferTubeNumber;
    case TransferTubeLength;
    case ChannelShieldSequence;
    case ChannelShieldNumber;
    case ChannelShieldID;
    case ChannelShieldName;
    case ChannelShieldNominalThickness;
    case ChannelShieldNominalTransmission;
    case FinalCumulativeTimeWeight;
    case BrachyControlPointSequence;
    case ControlPointRelativePosition;
    case ControlPoint3DPosition;
    case CumulativeTimeWeight;
    case CompensatorDivergence;
    case CompensatorMountingPosition;
    case SourceToCompensatorDistance;
    case TotalCompensatorTrayWaterEquivalentThickness;
    case IsocenterToCompensatorTrayDistance;
    case CompensatorColumnOffset;
    case IsocenterToCompensatorDistances;
    case CompensatorRelativeStoppingPowerRatio;
    case CompensatorMillingToolDiameter;
    case IonRangeCompensatorSequence;
    case CompensatorDescription;
    case CompensatorSurfaceRepresentationFlag;
    case RadiationMassNumber;
    case RadiationAtomicNumber;
    case RadiationChargeState;
    case ScanMode;
    case ModulatedScanModeType;
    case VirtualSourceAxisDistances;
    case SnoutSequence;
    case SnoutPosition;
    case SnoutID;
    case NumberOfRangeShifters;
    case RangeShifterSequence;
    case RangeShifterNumber;
    case RangeShifterID;
    case RangeShifterType;
    case RangeShifterDescription;
    case NumberOfLateralSpreadingDevices;
    case LateralSpreadingDeviceSequence;
    case LateralSpreadingDeviceNumber;
    case LateralSpreadingDeviceID;
    case LateralSpreadingDeviceType;
    case LateralSpreadingDeviceDescription;
    case LateralSpreadingDeviceWaterEquivalentThickness;
    case NumberOfRangeModulators;
    case RangeModulatorSequence;
    case RangeModulatorNumber;
    case RangeModulatorID;
    case RangeModulatorType;
    case RangeModulatorDescription;
    case BeamCurrentModulationID;
    case PatientSupportType;
    case PatientSupportID;
    case PatientSupportAccessoryCode;
    case TrayAccessoryCode;
    case FixationLightAzimuthalAngle;
    case FixationLightPolarAngle;
    case MetersetRate;
    case RangeShifterSettingsSequence;
    case RangeShifterSetting;
    case IsocenterToRangeShifterDistance;
    case RangeShifterWaterEquivalentThickness;
    case LateralSpreadingDeviceSettingsSequence;
    case LateralSpreadingDeviceSetting;
    case IsocenterToLateralSpreadingDeviceDistance;
    case RangeModulatorSettingsSequence;
    case RangeModulatorGatingStartValue;
    case RangeModulatorGatingStopValue;
    case RangeModulatorGatingStartWaterEquivalentThickness;
    case RangeModulatorGatingStopWaterEquivalentThickness;
    case IsocenterToRangeModulatorDistance;
    case ScanSpotTimeOffset;
    case ScanSpotTuneID;
    case ScanSpotPrescribedIndices;
    case NumberOfScanSpotPositions;
    case ScanSpotReordered;
    case ScanSpotPositionMap;
    case ScanSpotReorderingAllowed;
    case ScanSpotMetersetWeights;
    case ScanningSpotSize;
    case ScanSpotSizesDelivered;
    case NumberOfPaintings;
    case ScanSpotGantryAngles;
    case ScanSpotPatientSupportAngles;
    case IonToleranceTableSequence;
    case IonBeamSequence;
    case IonBeamLimitingDeviceSequence;
    case IonBlockSequence;
    case IonControlPointSequence;
    case IonWedgeSequence;
    case IonWedgePositionSequence;
    case ReferencedSetupImageSequence;
    case SetupImageComment;
    case MotionSynchronizationSequence;
    case ControlPointOrientation;
    case GeneralAccessorySequence;
    case GeneralAccessoryID;
    case GeneralAccessoryDescription;
    case GeneralAccessoryType;
    case GeneralAccessoryNumber;
    case SourceToGeneralAccessoryDistance;
    case IsocenterToGeneralAccessoryDistance;
    case ApplicatorGeometrySequence;
    case ApplicatorApertureShape;
    case ApplicatorOpening;
    case ApplicatorOpeningX;
    case ApplicatorOpeningY;
    case SourceToApplicatorMountingPositionDistance;
    case NumberOfBlockSlabItems;
    case BlockSlabSequence;
    case BlockSlabThickness;
    case BlockSlabNumber;
    case DeviceMotionControlSequence;
    case DeviceMotionExecutionMode;
    case DeviceMotionObservationMode;
    case DeviceMotionParameterCodeSequence;
    case DistalDepthFraction;
    case DistalDepth;
    case NominalRangeModulationFractions;
    case NominalRangeModulatedRegionDepths;
    case DepthDoseParametersSequence;
    case DeliveredDepthDoseParametersSequence;
    case DeliveredDistalDepthFraction;
    case DeliveredDistalDepth;
    case DeliveredNominalRangeModulationFractions;
    case DeliveredNominalRangeModulatedRegionDepths;
    case DeliveredReferenceDoseDefinition;
    case ReferenceDoseDefinition;
    case RTControlPointIndex;
    case RadiationGenerationModeIndex;
    case ReferencedDefinedDeviceIndex;
    case RadiationDoseIdentificationIndex;
    case NumberOfRTControlPoints;
    case ReferencedRadiationGenerationModeIndex;
    case TreatmentPositionIndex;
    case ReferencedDeviceIndex;
    case TreatmentPositionGroupLabel;
    case TreatmentPositionGroupUID;
    case TreatmentPositionGroupSequence;
    case ReferencedTreatmentPositionIndex;
    case ReferencedRadiationDoseIdentificationIndex;
    case RTAccessoryHolderWaterEquivalentThickness;
    case ReferencedRTAccessoryHolderDeviceIndex;
    case RTAccessoryHolderSlotExistenceFlag;
    case RTAccessoryHolderSlotSequence;
    case RTAccessoryHolderSlotID;
    case RTAccessoryHolderSlotDistance;
    case RTAccessorySlotDistance;
    case RTAccessoryHolderDefinitionSequence;
    case RTAccessoryDeviceSlotID;
    case RTRadiationSequence;
    case RadiationDoseSequence;
    case RadiationDoseIdentificationSequence;
    case RadiationDoseIdentificationLabel;
    case ReferenceDoseType;
    case PrimaryDoseValueIndicator;
    case DoseValuesSequence;
    case DoseValuePurpose;
    case ReferenceDosePointCoordinates;
    case RadiationDoseValuesParametersSequence;
    case MetersetToDoseMappingSequence;
    case ExpectedInVivoMeasurementValuesSequence;
    case ExpectedInVivoMeasurementValueIndex;
    case RadiationDoseInVivoMeasurementLabel;
    case RadiationDoseCentralAxisDisplacement;
    case RadiationDoseValue;
    case RadiationDoseSourceToSkinDistance;
    case RadiationDoseMeasurementPointCoordinates;
    case RadiationDoseSourceToExternalContourDistance;
    case RTToleranceSetSequence;
    case RTToleranceSetLabel;
    case AttributeToleranceValuesSequence;
    case ToleranceValue;
    case PatientSupportPositionToleranceSequence;
    case TreatmentTimeLimit;
    case CArmPhotonElectronControlPointSequence;
    case ReferencedRTRadiationSequence;
    case ReferencedRTInstanceSequence;
    case SourceToPatientSurfaceDistance;
    case TreatmentMachineSpecialModeCodeSequence;
    case IntendedNumberOfFractions;
    case RTRadiationSetIntent;
    case RTRadiationPhysicalAndGeometricContentDetailFlag;
    case RTRecordFlag;
    case TreatmentDeviceIdentificationSequence;
    case ReferencedRTPhysicianIntentSequence;
    case CumulativeMeterset;
    case DeliveryRate;
    case DeliveryRateUnitSequence;
    case TreatmentPositionSequence;
    case RadiationSourceAxisDistance;
    case NumberOfRTBeamLimitingDevices;
    case RTBeamLimitingDeviceProximalDistance;
    case RTBeamLimitingDeviceDistalDistance;
    case ParallelRTBeamDelimiterDeviceOrientationLabelCodeSequence;
    case BeamModifierOrientationAngle;
    case FixedRTBeamDelimiterDeviceSequence;
    case ParallelRTBeamDelimiterDeviceSequence;
    case NumberOfParallelRTBeamDelimiters;
    case ParallelRTBeamDelimiterBoundaries;
    case ParallelRTBeamDelimiterPositions;
    case RTBeamLimitingDeviceOffset;
    case RTBeamDelimiterGeometrySequence;
    case RTBeamLimitingDeviceDefinitionSequence;
    case ParallelRTBeamDelimiterOpeningMode;
    case ParallelRTBeamDelimiterLeafMountingSide;
    case WedgeDefinitionSequence;
    case RadiationBeamWedgeAngle;
    case RadiationBeamWedgeThinEdgeDistance;
    case RadiationBeamEffectiveWedgeAngle;
    case NumberOfWedgePositions;
    case RTBeamLimitingDeviceOpeningSequence;
    case NumberOfRTBeamLimitingDeviceOpenings;
    case RadiationDosimeterUnitSequence;
    case RTDeviceDistanceReferenceLocationCodeSequence;
    case RadiationDeviceConfigurationAndCommissioningKeySequence;
    case PatientSupportPositionParameterSequence;
    case PatientSupportPositionSpecificationMethod;
    case PatientSupportPositionDeviceParameterSequence;
    case DeviceOrderIndex;
    case PatientSupportPositionParameterOrderIndex;
    case PatientSupportPositionDeviceToleranceSequence;
    case PatientSupportPositionToleranceOrderIndex;
    case CompensatorDefinitionSequence;
    case CompensatorMapOrientation;
    case CompensatorProximalThicknessMap;
    case CompensatorDistalThicknessMap;
    case CompensatorBasePlaneOffset;
    case CompensatorShapeFabricationCodeSequence;
    case CompensatorShapeSequence;
    case RadiationBeamCompensatorMillingToolDiameter;
    case BlockDefinitionSequence;
    case BlockEdgeData;
    case BlockOrientation;
    case RadiationBeamBlockThickness;
    case RadiationBeamBlockSlabThickness;
    case BlockEdgeDataSequence;
    case NumberOfRTAccessoryHolders;
    case GeneralAccessoryDefinitionSequence;
    case NumberOfGeneralAccessories;
    case BolusDefinitionSequence;
    case NumberOfBoluses;
    case EquipmentFrameOfReferenceUID;
    case EquipmentFrameOfReferenceDescription;
    case EquipmentReferencePointCoordinatesSequence;
    case EquipmentReferencePointCodeSequence;
    case RTBeamLimitingDeviceAngle;
    case SourceRollAngle;
    case RadiationGenerationModeSequence;
    case RadiationGenerationModeLabel;
    case RadiationGenerationModeDescription;
    case RadiationGenerationModeMachineCodeSequence;
    case RadiationTypeCodeSequence;
    case NominalEnergy;
    case MinimumNominalEnergy;
    case MaximumNominalEnergy;
    case RadiationFluenceModifierCodeSequence;
    case EnergyUnitCodeSequence;
    case NumberOfRadiationGenerationModes;
    case PatientSupportDevicesSequence;
    case NumberOfPatientSupportDevices;
    case RTBeamModifierDefinitionDistance;
    case BeamAreaLimitSequence;
    case ReferencedRTPrescriptionSequence;
    case DoseValueInterpretation;
    case TreatmentSessionUID;
    case RTRadiationUsage;
    case ReferencedRTRadiationSetSequence;
    case ReferencedRTRadiationRecordSequence;
    case RTRadiationSetDeliveryNumber;
    case ClinicalFractionNumber;
    case RTTreatmentFractionCompletionStatus;
    case RTRadiationSetUsage;
    case TreatmentDeliveryContinuationFlag;
    case TreatmentRecordContentOrigin;
    case RTTreatmentTerminationStatus;
    case RTTreatmentTerminationReasonCodeSequence;
    case MachineSpecificTreatmentTerminationCodeSequence;
    case RTRadiationSalvageRecordControlPointSequence;
    case StartingMetersetValueKnownFlag;
    case TreatmentTerminationDescription;
    case TreatmentToleranceViolationSequence;
    case TreatmentToleranceViolationCategory;
    case TreatmentToleranceViolationAttributeSequence;
    case TreatmentToleranceViolationDescription;
    case TreatmentToleranceViolationIdentification;
    case TreatmentToleranceViolationDateTime;
    case RecordedRTControlPointDateTime;
    case ReferencedRadiationRTControlPointIndex;
    case AlternateValueSequence;
    case ConfirmationSequence;
    case InterlockSequence;
    case InterlockDateTime;
    case InterlockDescription;
    case InterlockOriginatingDeviceSequence;
    case InterlockCodeSequence;
    case InterlockResolutionCodeSequence;
    case InterlockResolutionUserSequence;
    case OverrideDateTime;
    case TreatmentToleranceViolationTypeCodeSequence;
    case TreatmentToleranceViolationCauseCodeSequence;
    case MeasuredMetersetToDoseMappingSequence;
    case ReferencedExpectedInVivoMeasurementValueIndex;
    case DoseMeasurementDeviceCodeSequence;
    case AdditionalParameterRecordingInstanceSequence;
    case InterlockOriginDescription;
    case RTPatientPositionScopeSequence;
    case ReferencedTreatmentPositionGroupUID;
    case RadiationOrderIndex;
    case OmittedRadiationSequence;
    case ReasonForOmissionCodeSequence;
    case RTDeliveryStartPatientPositionSequence;
    case RTTreatmentPreparationPatientPositionSequence;
    case ReferencedRTTreatmentPreparationSequence;
    case ReferencedPatientSetupPhotoSequence;
    case PatientTreatmentPreparationMethodCodeSequence;
    case PatientTreatmentPreparationProcedureParameterDescription;
    case PatientTreatmentPreparationDeviceSequence;
    case PatientTreatmentPreparationProcedureSequence;
    case PatientTreatmentPreparationProcedureCodeSequence;
    case PatientTreatmentPreparationMethodDescription;
    case PatientTreatmentPreparationProcedureParameterSequence;
    case PatientSetupPhotoDescription;
    case PatientTreatmentPreparationProcedureIndex;
    case ReferencedPatientSetupProcedureIndex;
    case RTRadiationTaskSequence;
    case RTPatientPositionDisplacementSequence;
    case RTPatientPositionSequence;
    case DisplacementReferenceLabel;
    case DisplacementMatrix;
    case PatientSupportDisplacementSequence;
    case DisplacementReferenceLocationCodeSequence;
    case RTRadiationSetDeliveryUsage;
    case PatientTreatmentPreparationSequence;
    case PatientToEquipmentRelationshipSequence;
    case ImagingEquipmentToTreatmentDeliveryDeviceRelationshipSequence;
    case ReferencedRTPlanSequence;
    case ReferencedBeamSequence;
    case ReferencedBeamNumber;
    case ReferencedReferenceImageNumber;
    case StartCumulativeMetersetWeight;
    case EndCumulativeMetersetWeight;
    case ReferencedBrachyApplicationSetupSequence;
    case ReferencedBrachyApplicationSetupNumber;
    case ReferencedSourceNumber;
    case ReferencedFractionGroupSequence;
    case ReferencedFractionGroupNumber;
    case ReferencedVerificationImageSequence;
    case ReferencedReferenceImageSequence;
    case ReferencedDoseReferenceSequence;
    case ReferencedDoseReferenceNumber;
    case BrachyReferencedDoseReferenceSequence;
    case ReferencedStructureSetSequence;
    case ReferencedPatientSetupNumber;
    case ReferencedDoseSequence;
    case ReferencedToleranceTableNumber;
    case ReferencedBolusSequence;
    case ReferencedWedgeNumber;
    case ReferencedCompensatorNumber;
    case ReferencedBlockNumber;
    case ReferencedControlPointIndex;
    case ReferencedControlPointSequence;
    case ReferencedStartControlPointIndex;
    case ReferencedStopControlPointIndex;
    case ReferencedRangeShifterNumber;
    case ReferencedLateralSpreadingDeviceNumber;
    case ReferencedRangeModulatorNumber;
    case OmittedBeamTaskSequence;
    case ReasonForOmission;
    case ReasonForOmissionDescription;
    case PrescriptionOverviewSequence;
    case TotalPrescriptionDose;
    case PlanOverviewSequence;
    case PlanOverviewIndex;
    case ReferencedPlanOverviewIndex;
    case NumberOfFractionsIncluded;
    case DoseCalibrationConditionsSequence;
    case AbsorbedDoseToMetersetRatio;
    case DelineatedRadiationFieldSize;
    case DoseCalibrationConditionsVerifiedFlag;
    case CalibrationReferencePointDepth;
    case GatingBeamHoldTransitionSequence;
    case BeamHoldTransition;
    case BeamHoldTransitionDateTime;
    case BeamHoldOriginatingDeviceSequence;
    case BeamHoldTransitionTriggerSource;
    case ApprovalStatus;
    case ReviewDate;
    case ReviewTime;
    case ReviewerName;
    case RadiobiologicalDoseEffectSequence;
    case RadiobiologicalDoseEffectFlag;
    case EffectiveDoseCalculationMethodCategoryCodeSequence;
    case EffectiveDoseCalculationMethodCodeSequence;
    case EffectiveDoseCalculationMethodDescription;
    case ConceptualVolumeUID;
    case OriginatingSOPInstanceReferenceSequence;
    case ConceptualVolumeConstituentSequence;
    case EquivalentConceptualVolumeInstanceReferenceSequence;
    case EquivalentConceptualVolumesSequence;
    case ReferencedConceptualVolumeUID;
    case ConceptualVolumeCombinationExpression;
    case ConceptualVolumeConstituentIndex;
    case ConceptualVolumeCombinationFlag;
    case ConceptualVolumeCombinationDescription;
    case ConceptualVolumeSegmentationDefinedFlag;
    case ConceptualVolumeSegmentationReferenceSequence;
    case ConceptualVolumeConstituentSegmentationReferenceSequence;
    case ConstituentConceptualVolumeUID;
    case DerivationConceptualVolumeSequence;
    case SourceConceptualVolumeUID;
    case ConceptualVolumeDerivationAlgorithmSequence;
    case ConceptualVolumeDescription;
    case SourceConceptualVolumeSequence;
    case AuthorIdentificationSequence;
    case ManufacturerModelVersion;
    case DeviceAlternateIdentifier;
    case DeviceAlternateIdentifierType;
    case DeviceAlternateIdentifierFormat;
    case SegmentationCreationTemplateLabel;
    case SegmentationTemplateUID;
    case ReferencedSegmentReferenceIndex;
    case SegmentReferenceSequence;
    case SegmentReferenceIndex;
    case DirectSegmentReferenceSequence;
    case CombinationSegmentReferenceSequence;
    case ConceptualVolumeSequence;
    case SegmentedRTAccessoryDeviceSequence;
    case SegmentCharacteristicsSequence;
    case RelatedSegmentCharacteristicsSequence;
    case SegmentCharacteristicsPrecedence;
    case RTSegmentAnnotationSequence;
    case SegmentAnnotationCategoryCodeSequence;
    case SegmentAnnotationTypeCodeSequence;
    case DeviceLabel;
    case DeviceTypeCodeSequence;
    case SegmentAnnotationTypeModifierCodeSequence;
    case PatientEquipmentRelationshipCodeSequence;
    case ReferencedFiducialsUID;
    case PatientTreatmentOrientationSequence;
    case UserContentLabel;
    case UserContentLongLabel;
    case EntityLabel;
    case EntityName;
    case EntityDescription;
    case EntityLongLabel;
    case DeviceIndex;
    case RTTreatmentPhaseIndex;
    case RTTreatmentPhaseUID;
    case RTPrescriptionIndex;
    case RTSegmentAnnotationIndex;
    case BasisRTTreatmentPhaseIndex;
    case RelatedRTTreatmentPhaseIndex;
    case ReferencedRTTreatmentPhaseIndex;
    case ReferencedRTPrescriptionIndex;
    case ReferencedParentRTPrescriptionIndex;
    case ManufacturerDeviceIdentifier;
    case InstanceLevelReferencedPerformedProcedureStepSequence;
    case RTTreatmentPhaseIntentPresenceFlag;
    case RadiotherapyTreatmentType;
    case TeletherapyRadiationType;
    case BrachytherapySourceType;
    case ReferencedRTTreatmentPhaseSequence;
    case ReferencedDirectSegmentInstanceSequence;
    case IntendedRTTreatmentPhaseSequence;
    case IntendedPhaseStartDate;
    case IntendedPhaseEndDate;
    case RTTreatmentPhaseIntervalSequence;
    case TemporalRelationshipIntervalAnchor;
    case MinimumNumberOfIntervalDays;
    case MaximumNumberOfIntervalDays;
    case PertinentSOPClassesInStudy;
    case PertinentSOPClassesInSeries;
    case RTPrescriptionLabel;
    case RTPhysicianIntentPredecessorSequence;
    case RTTreatmentApproachLabel;
    case RTPhysicianIntentSequence;
    case RTPhysicianIntentIndex;
    case RTTreatmentIntentType;
    case RTPhysicianIntentNarrative;
    case RTProtocolCodeSequence;
    case ReasonForSuperseding;
    case RTDiagnosisCodeSequence;
    case ReferencedRTPhysicianIntentIndex;
    case RTPhysicianIntentInputInstanceSequence;
    case RTAnatomicPrescriptionSequence;
    case PriorTreatmentDoseDescription;
    case PriorTreatmentReferenceSequence;
    case DosimetricObjectiveEvaluationScope;
    case TherapeuticRoleCategoryCodeSequence;
    case TherapeuticRoleTypeCodeSequence;
    case ConceptualVolumeOptimizationPrecedence;
    case ConceptualVolumeCategoryCodeSequence;
    case ConceptualVolumeBlockingConstraint;
    case ConceptualVolumeTypeCodeSequence;
    case ConceptualVolumeTypeModifierCodeSequence;
    case RTPrescriptionSequence;
    case DosimetricObjectiveSequence;
    case DosimetricObjectiveTypeCodeSequence;
    case DosimetricObjectiveUID;
    case ReferencedDosimetricObjectiveUID;
    case DosimetricObjectiveParameterSequence;
    case ReferencedDosimetricObjectivesSequence;
    case AbsoluteDosimetricObjectiveFlag;
    case DosimetricObjectiveWeight;
    case DosimetricObjectivePurpose;
    case PlanningInputInformationSequence;
    case TreatmentSite;
    case TreatmentSiteCodeSequence;
    case FractionPatternSequence;
    case TreatmentTechniqueNotes;
    case PrescriptionNotes;
    case NumberOfIntervalFractions;
    case NumberOfFractions;
    case IntendedDeliveryDuration;
    case FractionationNotes;
    case RTTreatmentTechniqueCodeSequence;
    case PrescriptionNotesSequence;
    case FractionBasedRelationshipSequence;
    case FractionBasedRelationshipIntervalAnchor;
    case MinimumHoursBetweenFractions;
    case IntendedFractionStartTime;
    case IntendedStartDayOfWeek;
    case WeekdayFractionPatternSequence;
    case DeliveryTimeStructureCodeSequence;
    case TreatmentSiteModifierCodeSequence;
    case RoboticPathNodeSetCodeSequence;
    case RoboticNodeIdentifier;
    case RTTreatmentSourceCoordinates;
    case RadiationSourceCoordinateSystemYawAngle;
    case RadiationSourceCoordinateSystemRollAngle;
    case RadiationSourceCoordinateSystemPitchAngle;
    case RoboticPathControlPointSequence;
    case TomotherapeuticControlPointSequence;
    case TomotherapeuticLeafOpenDurations;
    case TomotherapeuticLeafInitialClosedDurations;
    case ConceptualVolumeIdentificationSequence;
    case MACParametersSequence;
    case SharedFunctionalGroupsSequence;
    case PerFrameFunctionalGroupsSequence;
    case WaveformSequence;
    case ChannelMinimumValue;
    case ChannelMaximumValue;
    case WaveformBitsAllocated;
    case WaveformSampleInterpretation;
    case WaveformPaddingValue;
    case WaveformData;
    case FirstOrderPhaseCorrectionAngle;
    case SpectroscopyData;
    case ExtendedOffsetTable;
    case ExtendedOffsetTableLengths;
    case EncapsulatedPixelDataValueTotalLength;
    case FloatPixelData;
    case DoubleFloatPixelData;
    case PixelData;
    case DigitalSignaturesSequence;
    case DataSetTrailingPadding;
    case Item;
    case ItemDelimitationItem;
    case SequenceDelimitationItem;

    public function info(): TagInfo
    {
        [$group, $element, $valueRepresentation, $valueMultiplicity] = self::META[$this->name];

        return new TagInfo($group, $element, $valueRepresentation, $valueMultiplicity);
    }

    /** @var array<string, array{0: int, 1: int, 2: string, 3: string}> */
    private const array META = [
        'CommandGroupLength' => [0x0000, 0x0000, 'UL', '1'],
        'AffectedSOPClassUID' => [0x0000, 0x0002, 'UI', '1'],
        'RequestedSOPClassUID' => [0x0000, 0x0003, 'UI', '1'],
        'CommandField' => [0x0000, 0x0100, 'US', '1'],
        'MessageID' => [0x0000, 0x0110, 'US', '1'],
        'MessageIDBeingRespondedTo' => [0x0000, 0x0120, 'US', '1'],
        'MoveDestination' => [0x0000, 0x0600, 'AE', '1'],
        'Priority' => [0x0000, 0x0700, 'US', '1'],
        'CommandDataSetType' => [0x0000, 0x0800, 'US', '1'],
        'Status' => [0x0000, 0x0900, 'US', '1'],
        'OffendingElement' => [0x0000, 0x0901, 'AT', '1-n'],
        'ErrorComment' => [0x0000, 0x0902, 'LO', '1'],
        'ErrorID' => [0x0000, 0x0903, 'US', '1'],
        'AffectedSOPInstanceUID' => [0x0000, 0x1000, 'UI', '1'],
        'RequestedSOPInstanceUID' => [0x0000, 0x1001, 'UI', '1'],
        'EventTypeID' => [0x0000, 0x1002, 'US', '1'],
        'AttributeIdentifierList' => [0x0000, 0x1005, 'AT', '1-n'],
        'ActionTypeID' => [0x0000, 0x1008, 'US', '1'],
        'NumberOfRemainingSuboperations' => [0x0000, 0x1020, 'US', '1'],
        'NumberOfCompletedSuboperations' => [0x0000, 0x1021, 'US', '1'],
        'NumberOfFailedSuboperations' => [0x0000, 0x1022, 'US', '1'],
        'NumberOfWarningSuboperations' => [0x0000, 0x1023, 'US', '1'],
        'MoveOriginatorApplicationEntityTitle' => [0x0000, 0x1030, 'AE', '1'],
        'MoveOriginatorMessageID' => [0x0000, 0x1031, 'US', '1'],
        'FileMetaInformationGroupLength' => [0x0002, 0x0000, 'UL', '1'],
        'FileMetaInformationVersion' => [0x0002, 0x0001, 'OB', '1'],
        'MediaStorageSOPClassUID' => [0x0002, 0x0002, 'UI', '1'],
        'MediaStorageSOPInstanceUID' => [0x0002, 0x0003, 'UI', '1'],
        'TransferSyntaxUID' => [0x0002, 0x0010, 'UI', '1'],
        'ImplementationClassUID' => [0x0002, 0x0012, 'UI', '1'],
        'ImplementationVersionName' => [0x0002, 0x0013, 'SH', '1'],
        'SourceApplicationEntityTitle' => [0x0002, 0x0016, 'AE', '1'],
        'SendingApplicationEntityTitle' => [0x0002, 0x0017, 'AE', '1'],
        'ReceivingApplicationEntityTitle' => [0x0002, 0x0018, 'AE', '1'],
        'SourcePresentationAddress' => [0x0002, 0x0026, 'UR', '1'],
        'SendingPresentationAddress' => [0x0002, 0x0027, 'UR', '1'],
        'ReceivingPresentationAddress' => [0x0002, 0x0028, 'UR', '1'],
        'RTVMetaInformationVersion' => [0x0002, 0x0031, 'OB', '1'],
        'RTVCommunicationSOPClassUID' => [0x0002, 0x0032, 'UI', '1'],
        'RTVCommunicationSOPInstanceUID' => [0x0002, 0x0033, 'UI', '1'],
        'RTVSourceIdentifier' => [0x0002, 0x0035, 'OB', '1'],
        'RTVFlowIdentifier' => [0x0002, 0x0036, 'OB', '1'],
        'RTVFlowRTPSamplingRate' => [0x0002, 0x0037, 'UL', '1'],
        'RTVFlowActualFrameDuration' => [0x0002, 0x0038, 'FD', '1'],
        'PrivateInformationCreatorUID' => [0x0002, 0x0100, 'UI', '1'],
        'PrivateInformation' => [0x0002, 0x0102, 'OB', '1'],
        'FileSetID' => [0x0004, 0x1130, 'CS', '1'],
        'FileSetDescriptorFileID' => [0x0004, 0x1141, 'CS', '1-8'],
        'SpecificCharacterSetOfFileSetDescriptorFile' => [0x0004, 0x1142, 'CS', '1'],
        'OffsetOfTheFirstDirectoryRecordOfTheRootDirectoryEntity' => [0x0004, 0x1200, 'up', '1'],
        'OffsetOfTheLastDirectoryRecordOfTheRootDirectoryEntity' => [0x0004, 0x1202, 'up', '1'],
        'FileSetConsistencyFlag' => [0x0004, 0x1212, 'US', '1'],
        'DirectoryRecordSequence' => [0x0004, 0x1220, 'SQ', '1'],
        'OffsetOfTheNextDirectoryRecord' => [0x0004, 0x1400, 'up', '1'],
        'RecordInUseFlag' => [0x0004, 0x1410, 'US', '1'],
        'OffsetOfReferencedLowerLevelDirectoryEntity' => [0x0004, 0x1420, 'up', '1'],
        'DirectoryRecordType' => [0x0004, 0x1430, 'CS', '1'],
        'PrivateRecordUID' => [0x0004, 0x1432, 'UI', '1'],
        'ReferencedFileID' => [0x0004, 0x1500, 'CS', '1-8'],
        'ReferencedSOPClassUIDInFile' => [0x0004, 0x1510, 'UI', '1'],
        'ReferencedSOPInstanceUIDInFile' => [0x0004, 0x1511, 'UI', '1'],
        'ReferencedTransferSyntaxUIDInFile' => [0x0004, 0x1512, 'UI', '1'],
        'ReferencedRelatedGeneralSOPClassUIDInFile' => [0x0004, 0x151a, 'UI', '1-n'],
        'CurrentFrameFunctionalGroupsSequence' => [0x0006, 0x0001, 'SQ', '1'],
        'SpecificCharacterSet' => [0x0008, 0x0005, 'CS', '1-n'],
        'LanguageCodeSequence' => [0x0008, 0x0006, 'SQ', '1'],
        'ImageType' => [0x0008, 0x0008, 'CS', '2-n'],
        'InstanceCreationDate' => [0x0008, 0x0012, 'DA', '1'],
        'InstanceCreationTime' => [0x0008, 0x0013, 'TM', '1'],
        'InstanceCreatorUID' => [0x0008, 0x0014, 'UI', '1'],
        'InstanceCoercionDateTime' => [0x0008, 0x0015, 'DT', '1'],
        'SOPClassUID' => [0x0008, 0x0016, 'UI', '1'],
        'AcquisitionUID' => [0x0008, 0x0017, 'UI', '1'],
        'SOPInstanceUID' => [0x0008, 0x0018, 'UI', '1'],
        'PyramidUID' => [0x0008, 0x0019, 'UI', '1'],
        'RelatedGeneralSOPClassUID' => [0x0008, 0x001a, 'UI', '1-n'],
        'OriginalSpecializedSOPClassUID' => [0x0008, 0x001b, 'UI', '1'],
        'SyntheticData' => [0x0008, 0x001c, 'CS', '1'],
        'SensitiveContentCodeSequence' => [0x0008, 0x001d, 'SQ', '1'],
        'StudyDate' => [0x0008, 0x0020, 'DA', '1'],
        'SeriesDate' => [0x0008, 0x0021, 'DA', '1'],
        'AcquisitionDate' => [0x0008, 0x0022, 'DA', '1'],
        'ContentDate' => [0x0008, 0x0023, 'DA', '1'],
        'AcquisitionDateTime' => [0x0008, 0x002a, 'DT', '1'],
        'StudyTime' => [0x0008, 0x0030, 'TM', '1'],
        'SeriesTime' => [0x0008, 0x0031, 'TM', '1'],
        'AcquisitionTime' => [0x0008, 0x0032, 'TM', '1'],
        'ContentTime' => [0x0008, 0x0033, 'TM', '1'],
        'AccessionNumber' => [0x0008, 0x0050, 'SH', '1'],
        'IssuerOfAccessionNumberSequence' => [0x0008, 0x0051, 'SQ', '1'],
        'QueryRetrieveLevel' => [0x0008, 0x0052, 'CS', '1'],
        'QueryRetrieveView' => [0x0008, 0x0053, 'CS', '1'],
        'RetrieveAETitle' => [0x0008, 0x0054, 'AE', '1-n'],
        'StationAETitle' => [0x0008, 0x0055, 'AE', '1'],
        'InstanceAvailability' => [0x0008, 0x0056, 'CS', '1'],
        'FailedSOPInstanceUIDList' => [0x0008, 0x0058, 'UI', '1-n'],
        'Modality' => [0x0008, 0x0060, 'CS', '1'],
        'ModalitiesInStudy' => [0x0008, 0x0061, 'CS', '1-n'],
        'SOPClassesInStudy' => [0x0008, 0x0062, 'UI', '1-n'],
        'AnatomicRegionsInStudyCodeSequence' => [0x0008, 0x0063, 'SQ', '1'],
        'ConversionType' => [0x0008, 0x0064, 'CS', '1'],
        'PresentationIntentType' => [0x0008, 0x0068, 'CS', '1'],
        'Manufacturer' => [0x0008, 0x0070, 'LO', '1'],
        'InstitutionName' => [0x0008, 0x0080, 'LO', '1'],
        'InstitutionAddress' => [0x0008, 0x0081, 'ST', '1'],
        'InstitutionCodeSequence' => [0x0008, 0x0082, 'SQ', '1'],
        'ReferringPhysicianName' => [0x0008, 0x0090, 'PN', '1'],
        'ReferringPhysicianAddress' => [0x0008, 0x0092, 'ST', '1'],
        'ReferringPhysicianTelephoneNumbers' => [0x0008, 0x0094, 'SH', '1-n'],
        'ReferringPhysicianIdentificationSequence' => [0x0008, 0x0096, 'SQ', '1'],
        'ConsultingPhysicianName' => [0x0008, 0x009c, 'PN', '1-n'],
        'ConsultingPhysicianIdentificationSequence' => [0x0008, 0x009d, 'SQ', '1'],
        'CodeValue' => [0x0008, 0x0100, 'SH', '1'],
        'CodingSchemeDesignator' => [0x0008, 0x0102, 'SH', '1'],
        'CodingSchemeVersion' => [0x0008, 0x0103, 'SH', '1'],
        'CodeMeaning' => [0x0008, 0x0104, 'LO', '1'],
        'MappingResource' => [0x0008, 0x0105, 'CS', '1'],
        'ContextGroupVersion' => [0x0008, 0x0106, 'DT', '1'],
        'ContextGroupLocalVersion' => [0x0008, 0x0107, 'DT', '1'],
        'CodingSchemeResourcesSequence' => [0x0008, 0x0109, 'SQ', '1'],
        'CodingSchemeURLType' => [0x0008, 0x010a, 'CS', '1'],
        'ContextGroupExtensionFlag' => [0x0008, 0x010b, 'CS', '1'],
        'CodingSchemeUID' => [0x0008, 0x010c, 'UI', '1'],
        'ContextGroupExtensionCreatorUID' => [0x0008, 0x010d, 'UI', '1'],
        'CodingSchemeURL' => [0x0008, 0x010e, 'UR', '1'],
        'ContextIdentifier' => [0x0008, 0x010f, 'CS', '1'],
        'CodingSchemeIdentificationSequence' => [0x0008, 0x0110, 'SQ', '1'],
        'CodingSchemeRegistry' => [0x0008, 0x0112, 'LO', '1'],
        'CodingSchemeExternalID' => [0x0008, 0x0114, 'ST', '1'],
        'CodingSchemeName' => [0x0008, 0x0115, 'ST', '1'],
        'CodingSchemeResponsibleOrganization' => [0x0008, 0x0116, 'ST', '1'],
        'ContextUID' => [0x0008, 0x0117, 'UI', '1'],
        'MappingResourceUID' => [0x0008, 0x0118, 'UI', '1'],
        'LongCodeValue' => [0x0008, 0x0119, 'UC', '1'],
        'URNCodeValue' => [0x0008, 0x0120, 'UR', '1'],
        'EquivalentCodeSequence' => [0x0008, 0x0121, 'SQ', '1'],
        'MappingResourceName' => [0x0008, 0x0122, 'LO', '1'],
        'ContextGroupIdentificationSequence' => [0x0008, 0x0123, 'SQ', '1'],
        'MappingResourceIdentificationSequence' => [0x0008, 0x0124, 'SQ', '1'],
        'TimezoneOffsetFromUTC' => [0x0008, 0x0201, 'SH', '1'],
        'ResponsibleGroupCodeSequence' => [0x0008, 0x0220, 'SQ', '1'],
        'EquipmentModality' => [0x0008, 0x0221, 'CS', '1'],
        'ManufacturerRelatedModelGroup' => [0x0008, 0x0222, 'LO', '1'],
        'PrivateDataElementCharacteristicsSequence' => [0x0008, 0x0300, 'SQ', '1'],
        'PrivateGroupReference' => [0x0008, 0x0301, 'US', '1'],
        'PrivateCreatorReference' => [0x0008, 0x0302, 'LO', '1'],
        'BlockIdentifyingInformationStatus' => [0x0008, 0x0303, 'CS', '1'],
        'NonidentifyingPrivateElements' => [0x0008, 0x0304, 'US', '1-n'],
        'DeidentificationActionSequence' => [0x0008, 0x0305, 'SQ', '1'],
        'IdentifyingPrivateElements' => [0x0008, 0x0306, 'US', '1-n'],
        'DeidentificationAction' => [0x0008, 0x0307, 'CS', '1'],
        'PrivateDataElement' => [0x0008, 0x0308, 'US', '1'],
        'PrivateDataElementValueMultiplicity' => [0x0008, 0x0309, 'UL', '1-3'],
        'PrivateDataElementValueRepresentation' => [0x0008, 0x030a, 'CS', '1'],
        'PrivateDataElementNumberOfItems' => [0x0008, 0x030b, 'UL', '1-2'],
        'PrivateDataElementName' => [0x0008, 0x030c, 'UC', '1'],
        'PrivateDataElementKeyword' => [0x0008, 0x030d, 'UC', '1'],
        'PrivateDataElementDescription' => [0x0008, 0x030e, 'UT', '1'],
        'PrivateDataElementEncoding' => [0x0008, 0x030f, 'UT', '1'],
        'PrivateDataElementDefinitionSequence' => [0x0008, 0x0310, 'SQ', '1'],
        'ScopeOfInventorySequence' => [0x0008, 0x0400, 'SQ', '1'],
        'InventoryPurpose' => [0x0008, 0x0401, 'LT', '1'],
        'InventoryInstanceDescription' => [0x0008, 0x0402, 'LT', '1'],
        'InventoryLevel' => [0x0008, 0x0403, 'CS', '1'],
        'ItemInventoryDateTime' => [0x0008, 0x0404, 'DT', '1'],
        'RemovedFromOperationalUse' => [0x0008, 0x0405, 'CS', '1'],
        'ReasonForRemovalCodeSequence' => [0x0008, 0x0406, 'SQ', '1'],
        'StoredInstanceBaseURI' => [0x0008, 0x0407, 'UR', '1'],
        'FolderAccessURI' => [0x0008, 0x0408, 'UR', '1'],
        'FileAccessURI' => [0x0008, 0x0409, 'UR', '1'],
        'ContainerFileType' => [0x0008, 0x040a, 'CS', '1'],
        'FilenameInContainer' => [0x0008, 0x040b, 'UR', '1'],
        'FileOffsetInContainer' => [0x0008, 0x040c, 'UV', '1'],
        'FileLengthInContainer' => [0x0008, 0x040d, 'UV', '1'],
        'StoredInstanceTransferSyntaxUID' => [0x0008, 0x040e, 'UI', '1'],
        'ExtendedMatchingMechanisms' => [0x0008, 0x040f, 'CS', '1-n'],
        'RangeMatchingSequence' => [0x0008, 0x0410, 'SQ', '1'],
        'ListOfUIDMatchingSequence' => [0x0008, 0x0411, 'SQ', '1'],
        'EmptyValueMatchingSequence' => [0x0008, 0x0412, 'SQ', '1'],
        'GeneralMatchingSequence' => [0x0008, 0x0413, 'SQ', '1'],
        'RequestedStatusInterval' => [0x0008, 0x0414, 'US', '1'],
        'RetainInstances' => [0x0008, 0x0415, 'CS', '1'],
        'ExpirationDateTime' => [0x0008, 0x0416, 'DT', '1'],
        'TransactionStatus' => [0x0008, 0x0417, 'CS', '1'],
        'TransactionStatusComment' => [0x0008, 0x0418, 'LT', '1'],
        'FileSetAccessSequence' => [0x0008, 0x0419, 'SQ', '1'],
        'FileAccessSequence' => [0x0008, 0x041a, 'SQ', '1'],
        'RecordKey' => [0x0008, 0x041b, 'OB', '1'],
        'PriorRecordKey' => [0x0008, 0x041c, 'OB', '1'],
        'MetadataSequence' => [0x0008, 0x041d, 'SQ', '1'],
        'UpdatedMetadataSequence' => [0x0008, 0x041e, 'SQ', '1'],
        'StudyUpdateDateTime' => [0x0008, 0x041f, 'DT', '1'],
        'InventoryAccessEndPointsSequence' => [0x0008, 0x0420, 'SQ', '1'],
        'StudyAccessEndPointsSequence' => [0x0008, 0x0421, 'SQ', '1'],
        'IncorporatedInventoryInstanceSequence' => [0x0008, 0x0422, 'SQ', '1'],
        'InventoriedStudiesSequence' => [0x0008, 0x0423, 'SQ', '1'],
        'InventoriedSeriesSequence' => [0x0008, 0x0424, 'SQ', '1'],
        'InventoriedInstancesSequence' => [0x0008, 0x0425, 'SQ', '1'],
        'InventoryCompletionStatus' => [0x0008, 0x0426, 'CS', '1'],
        'NumberOfStudyRecordsInInstance' => [0x0008, 0x0427, 'UL', '1'],
        'TotalNumberOfStudyRecords' => [0x0008, 0x0428, 'UV', '1'],
        'MaximumNumberOfRecords' => [0x0008, 0x0429, 'UV', '1'],
        'StationName' => [0x0008, 0x1010, 'SH', '1'],
        'StudyDescription' => [0x0008, 0x1030, 'LO', '1'],
        'ProcedureCodeSequence' => [0x0008, 0x1032, 'SQ', '1'],
        'SeriesDescription' => [0x0008, 0x103e, 'LO', '1'],
        'SeriesDescriptionCodeSequence' => [0x0008, 0x103f, 'SQ', '1'],
        'InstitutionalDepartmentName' => [0x0008, 0x1040, 'LO', '1'],
        'InstitutionalDepartmentTypeCodeSequence' => [0x0008, 0x1041, 'SQ', '1'],
        'PhysiciansOfRecord' => [0x0008, 0x1048, 'PN', '1-n'],
        'PhysiciansOfRecordIdentificationSequence' => [0x0008, 0x1049, 'SQ', '1'],
        'PerformingPhysicianName' => [0x0008, 0x1050, 'PN', '1-n'],
        'PerformingPhysicianIdentificationSequence' => [0x0008, 0x1052, 'SQ', '1'],
        'NameOfPhysiciansReadingStudy' => [0x0008, 0x1060, 'PN', '1-n'],
        'PhysiciansReadingStudyIdentificationSequence' => [0x0008, 0x1062, 'SQ', '1'],
        'OperatorsName' => [0x0008, 0x1070, 'PN', '1-n'],
        'OperatorIdentificationSequence' => [0x0008, 0x1072, 'SQ', '1'],
        'AdmittingDiagnosesDescription' => [0x0008, 0x1080, 'LO', '1-n'],
        'AdmittingDiagnosesCodeSequence' => [0x0008, 0x1084, 'SQ', '1'],
        'PyramidDescription' => [0x0008, 0x1088, 'LO', '1'],
        'ManufacturerModelName' => [0x0008, 0x1090, 'LO', '1'],
        'ReferencedStudySequence' => [0x0008, 0x1110, 'SQ', '1'],
        'ReferencedPerformedProcedureStepSequence' => [0x0008, 0x1111, 'SQ', '1'],
        'ReferencedInstancesBySOPClassSequence' => [0x0008, 0x1112, 'SQ', '1'],
        'ReferencedSeriesSequence' => [0x0008, 0x1115, 'SQ', '1'],
        'ReferencedPatientSequence' => [0x0008, 0x1120, 'SQ', '1'],
        'ReferencedVisitSequence' => [0x0008, 0x1125, 'SQ', '1'],
        'ReferencedStereometricInstanceSequence' => [0x0008, 0x1134, 'SQ', '1'],
        'ReferencedWaveformSequence' => [0x0008, 0x113a, 'SQ', '1'],
        'ReferencedImageSequence' => [0x0008, 0x1140, 'SQ', '1'],
        'ReferencedInstanceSequence' => [0x0008, 0x114a, 'SQ', '1'],
        'ReferencedRealWorldValueMappingInstanceSequence' => [0x0008, 0x114b, 'SQ', '1'],
        'ReferencedSegmentationSequence' => [0x0008, 0x114c, 'SQ', '1'],
        'ReferencedSurfaceSegmentationSequence' => [0x0008, 0x114d, 'SQ', '1'],
        'ReferencedSOPClassUID' => [0x0008, 0x1150, 'UI', '1'],
        'ReferencedSOPInstanceUID' => [0x0008, 0x1155, 'UI', '1'],
        'DefinitionSourceSequence' => [0x0008, 0x1156, 'SQ', '1'],
        'SOPClassesSupported' => [0x0008, 0x115a, 'UI', '1-n'],
        'ReferencedFrameNumber' => [0x0008, 0x1160, 'IS', '1-n'],
        'SimpleFrameList' => [0x0008, 0x1161, 'UL', '1-n'],
        'CalculatedFrameList' => [0x0008, 0x1162, 'UL', '3-3n'],
        'TimeRange' => [0x0008, 0x1163, 'FD', '2'],
        'FrameExtractionSequence' => [0x0008, 0x1164, 'SQ', '1'],
        'MultiFrameSourceSOPInstanceUID' => [0x0008, 0x1167, 'UI', '1'],
        'RetrieveURL' => [0x0008, 0x1190, 'UR', '1'],
        'TransactionUID' => [0x0008, 0x1195, 'UI', '1'],
        'WarningReason' => [0x0008, 0x1196, 'US', '1'],
        'FailureReason' => [0x0008, 0x1197, 'US', '1'],
        'FailedSOPSequence' => [0x0008, 0x1198, 'SQ', '1'],
        'ReferencedSOPSequence' => [0x0008, 0x1199, 'SQ', '1'],
        'OtherFailuresSequence' => [0x0008, 0x119a, 'SQ', '1'],
        'FailedStudySequence' => [0x0008, 0x119b, 'SQ', '1'],
        'StudiesContainingOtherReferencedInstancesSequence' => [0x0008, 0x1200, 'SQ', '1'],
        'RelatedSeriesSequence' => [0x0008, 0x1250, 'SQ', '1'],
        'PrincipalDiagnosisCodeSequence' => [0x0008, 0x1301, 'SQ', '1'],
        'PrimaryDiagnosisCodeSequence' => [0x0008, 0x1302, 'SQ', '1'],
        'SecondaryDiagnosesCodeSequence' => [0x0008, 0x1303, 'SQ', '1'],
        'HistologicalDiagnosesCodeSequence' => [0x0008, 0x1304, 'SQ', '1'],
        'DerivationDescription' => [0x0008, 0x2111, 'ST', '1'],
        'SourceImageSequence' => [0x0008, 0x2112, 'SQ', '1'],
        'StageName' => [0x0008, 0x2120, 'SH', '1'],
        'StageNumber' => [0x0008, 0x2122, 'IS', '1'],
        'NumberOfStages' => [0x0008, 0x2124, 'IS', '1'],
        'ViewName' => [0x0008, 0x2127, 'SH', '1'],
        'ViewNumber' => [0x0008, 0x2128, 'IS', '1'],
        'NumberOfEventTimers' => [0x0008, 0x2129, 'IS', '1'],
        'NumberOfViewsInStage' => [0x0008, 0x212a, 'IS', '1'],
        'EventElapsedTimes' => [0x0008, 0x2130, 'DS', '1-n'],
        'EventTimerNames' => [0x0008, 0x2132, 'LO', '1-n'],
        'EventTimerSequence' => [0x0008, 0x2133, 'SQ', '1'],
        'EventTimeOffset' => [0x0008, 0x2134, 'FD', '1'],
        'EventCodeSequence' => [0x0008, 0x2135, 'SQ', '1'],
        'StartTrim' => [0x0008, 0x2142, 'IS', '1'],
        'StopTrim' => [0x0008, 0x2143, 'IS', '1'],
        'RecommendedDisplayFrameRate' => [0x0008, 0x2144, 'IS', '1'],
        'AnatomicRegionSequence' => [0x0008, 0x2218, 'SQ', '1'],
        'AnatomicRegionModifierSequence' => [0x0008, 0x2220, 'SQ', '1'],
        'PrimaryAnatomicStructureSequence' => [0x0008, 0x2228, 'SQ', '1'],
        'PrimaryAnatomicStructureModifierSequence' => [0x0008, 0x2230, 'SQ', '1'],
        'AlternateRepresentationSequence' => [0x0008, 0x3001, 'SQ', '1'],
        'AvailableTransferSyntaxUID' => [0x0008, 0x3002, 'UI', '1-n'],
        'IrradiationEventUID' => [0x0008, 0x3010, 'UI', '1-n'],
        'SourceIrradiationEventSequence' => [0x0008, 0x3011, 'SQ', '1'],
        'RadiopharmaceuticalAdministrationEventUID' => [0x0008, 0x3012, 'UI', '1'],
        'FrameType' => [0x0008, 0x9007, 'CS', '4-5'],
        'ReferencedImageEvidenceSequence' => [0x0008, 0x9092, 'SQ', '1'],
        'ReferencedRawDataSequence' => [0x0008, 0x9121, 'SQ', '1'],
        'CreatorVersionUID' => [0x0008, 0x9123, 'UI', '1'],
        'DerivationImageSequence' => [0x0008, 0x9124, 'SQ', '1'],
        'SourceImageEvidenceSequence' => [0x0008, 0x9154, 'SQ', '1'],
        'PixelPresentation' => [0x0008, 0x9205, 'CS', '1'],
        'VolumetricProperties' => [0x0008, 0x9206, 'CS', '1'],
        'VolumeBasedCalculationTechnique' => [0x0008, 0x9207, 'CS', '1'],
        'ComplexImageComponent' => [0x0008, 0x9208, 'CS', '1'],
        'AcquisitionContrast' => [0x0008, 0x9209, 'CS', '1'],
        'DerivationCodeSequence' => [0x0008, 0x9215, 'SQ', '1'],
        'ReferencedPresentationStateSequence' => [0x0008, 0x9237, 'SQ', '1'],
        'ReferencedOtherPlaneSequence' => [0x0008, 0x9410, 'SQ', '1'],
        'FrameDisplaySequence' => [0x0008, 0x9458, 'SQ', '1'],
        'RecommendedDisplayFrameRateInFloat' => [0x0008, 0x9459, 'FL', '1'],
        'SkipFrameRangeFlag' => [0x0008, 0x9460, 'CS', '1'],
        'PatientName' => [0x0010, 0x0010, 'PN', '1'],
        'PersonNamesToUseSequence' => [0x0010, 0x0011, 'SQ', '1'],
        'NameToUse' => [0x0010, 0x0012, 'LT', '1'],
        'NameToUseComment' => [0x0010, 0x0013, 'UT', '1'],
        'ThirdPersonPronounsSequence' => [0x0010, 0x0014, 'SQ', '1'],
        'PronounCodeSequence' => [0x0010, 0x0015, 'SQ', '1'],
        'PronounComment' => [0x0010, 0x0016, 'UT', '1'],
        'PatientID' => [0x0010, 0x0020, 'LO', '1'],
        'IssuerOfPatientID' => [0x0010, 0x0021, 'LO', '1'],
        'TypeOfPatientID' => [0x0010, 0x0022, 'CS', '1'],
        'IssuerOfPatientIDQualifiersSequence' => [0x0010, 0x0024, 'SQ', '1'],
        'SourcePatientGroupIdentificationSequence' => [0x0010, 0x0026, 'SQ', '1'],
        'GroupOfPatientsIdentificationSequence' => [0x0010, 0x0027, 'SQ', '1'],
        'SubjectRelativePositionInImage' => [0x0010, 0x0028, 'US', '3'],
        'PatientBirthDate' => [0x0010, 0x0030, 'DA', '1'],
        'PatientBirthTime' => [0x0010, 0x0032, 'TM', '1'],
        'PatientBirthDateInAlternativeCalendar' => [0x0010, 0x0033, 'LO', '1'],
        'PatientDeathDateInAlternativeCalendar' => [0x0010, 0x0034, 'LO', '1'],
        'PatientAlternativeCalendar' => [0x0010, 0x0035, 'CS', '1'],
        'PatientSex' => [0x0010, 0x0040, 'CS', '1'],
        'GenderIdentitySequence' => [0x0010, 0x0041, 'SQ', '1'],
        'SexParametersForClinicalUseCategoryComment' => [0x0010, 0x0042, 'UT', '1'],
        'SexParametersForClinicalUseCategorySequence' => [0x0010, 0x0043, 'SQ', '1'],
        'GenderIdentityCodeSequence' => [0x0010, 0x0044, 'SQ', '1'],
        'GenderIdentityComment' => [0x0010, 0x0045, 'UT', '1'],
        'SexParametersForClinicalUseCategoryCodeSequence' => [0x0010, 0x0046, 'SQ', '1'],
        'SexParametersForClinicalUseCategoryReference' => [0x0010, 0x0047, 'UR', '1-n'],
        'PatientInsurancePlanCodeSequence' => [0x0010, 0x0050, 'SQ', '1'],
        'PatientPrimaryLanguageCodeSequence' => [0x0010, 0x0101, 'SQ', '1'],
        'PatientPrimaryLanguageModifierCodeSequence' => [0x0010, 0x0102, 'SQ', '1'],
        'QualityControlSubject' => [0x0010, 0x0200, 'CS', '1'],
        'QualityControlSubjectTypeCodeSequence' => [0x0010, 0x0201, 'SQ', '1'],
        'StrainDescription' => [0x0010, 0x0212, 'UC', '1'],
        'StrainNomenclature' => [0x0010, 0x0213, 'LO', '1'],
        'StrainStockNumber' => [0x0010, 0x0214, 'LO', '1'],
        'StrainSourceRegistryCodeSequence' => [0x0010, 0x0215, 'SQ', '1'],
        'StrainStockSequence' => [0x0010, 0x0216, 'SQ', '1'],
        'StrainSource' => [0x0010, 0x0217, 'LO', '1'],
        'StrainAdditionalInformation' => [0x0010, 0x0218, 'UT', '1'],
        'StrainCodeSequence' => [0x0010, 0x0219, 'SQ', '1'],
        'GeneticModificationsSequence' => [0x0010, 0x0221, 'SQ', '1'],
        'GeneticModificationsDescription' => [0x0010, 0x0222, 'UC', '1'],
        'GeneticModificationsNomenclature' => [0x0010, 0x0223, 'LO', '1'],
        'GeneticModificationsCodeSequence' => [0x0010, 0x0229, 'SQ', '1'],
        'OtherPatientNames' => [0x0010, 0x1001, 'PN', '1-n'],
        'OtherPatientIDsSequence' => [0x0010, 0x1002, 'SQ', '1'],
        'PatientBirthName' => [0x0010, 0x1005, 'PN', '1'],
        'PatientAge' => [0x0010, 0x1010, 'AS', '1'],
        'PatientSize' => [0x0010, 0x1020, 'DS', '1'],
        'PatientSizeCodeSequence' => [0x0010, 0x1021, 'SQ', '1'],
        'PatientBodyMassIndex' => [0x0010, 0x1022, 'DS', '1'],
        'MeasuredAPDimension' => [0x0010, 0x1023, 'DS', '1'],
        'MeasuredLateralDimension' => [0x0010, 0x1024, 'DS', '1'],
        'PatientWeight' => [0x0010, 0x1030, 'DS', '1'],
        'PatientAddress' => [0x0010, 0x1040, 'LO', '1'],
        'PatientMotherBirthName' => [0x0010, 0x1060, 'PN', '1'],
        'MilitaryRank' => [0x0010, 0x1080, 'LO', '1'],
        'BranchOfService' => [0x0010, 0x1081, 'LO', '1'],
        'ReferencedPatientPhotoSequence' => [0x0010, 0x1100, 'SQ', '1'],
        'MedicalAlerts' => [0x0010, 0x2000, 'LO', '1-n'],
        'Allergies' => [0x0010, 0x2110, 'LO', '1-n'],
        'CountryOfResidence' => [0x0010, 0x2150, 'LO', '1'],
        'RegionOfResidence' => [0x0010, 0x2152, 'LO', '1'],
        'PatientTelephoneNumbers' => [0x0010, 0x2154, 'SH', '1-n'],
        'PatientTelecomInformation' => [0x0010, 0x2155, 'LT', '1'],
        'EthnicGroupCodeSequence' => [0x0010, 0x2161, 'SQ', '1'],
        'EthnicGroups' => [0x0010, 0x2162, 'UC', '1-n'],
        'Occupation' => [0x0010, 0x2180, 'SH', '1'],
        'SmokingStatus' => [0x0010, 0x21a0, 'CS', '1'],
        'AdditionalPatientHistory' => [0x0010, 0x21b0, 'LT', '1'],
        'PregnancyStatus' => [0x0010, 0x21c0, 'US', '1'],
        'LastMenstrualDate' => [0x0010, 0x21d0, 'DA', '1'],
        'PatientReligiousPreference' => [0x0010, 0x21f0, 'LO', '1'],
        'PatientSpeciesDescription' => [0x0010, 0x2201, 'LO', '1'],
        'PatientSpeciesCodeSequence' => [0x0010, 0x2202, 'SQ', '1'],
        'PatientSexNeutered' => [0x0010, 0x2203, 'CS', '1'],
        'AnatomicalOrientationType' => [0x0010, 0x2210, 'CS', '1'],
        'PatientBreedDescription' => [0x0010, 0x2292, 'LO', '1'],
        'PatientBreedCodeSequence' => [0x0010, 0x2293, 'SQ', '1'],
        'BreedRegistrationSequence' => [0x0010, 0x2294, 'SQ', '1'],
        'BreedRegistrationNumber' => [0x0010, 0x2295, 'LO', '1'],
        'BreedRegistryCodeSequence' => [0x0010, 0x2296, 'SQ', '1'],
        'ResponsiblePerson' => [0x0010, 0x2297, 'PN', '1'],
        'ResponsiblePersonRole' => [0x0010, 0x2298, 'CS', '1'],
        'ResponsibleOrganization' => [0x0010, 0x2299, 'LO', '1'],
        'PatientComments' => [0x0010, 0x4000, 'LT', '1'],
        'ExaminedBodyThickness' => [0x0010, 0x9431, 'FL', '1'],
        'ClinicalTrialSponsorName' => [0x0012, 0x0010, 'LO', '1'],
        'ClinicalTrialProtocolID' => [0x0012, 0x0020, 'LO', '1'],
        'ClinicalTrialProtocolName' => [0x0012, 0x0021, 'LO', '1'],
        'IssuerOfClinicalTrialProtocolID' => [0x0012, 0x0022, 'LO', '1'],
        'OtherClinicalTrialProtocolIDsSequence' => [0x0012, 0x0023, 'SQ', '1'],
        'ClinicalTrialSiteID' => [0x0012, 0x0030, 'LO', '1'],
        'ClinicalTrialSiteName' => [0x0012, 0x0031, 'LO', '1'],
        'IssuerOfClinicalTrialSiteID' => [0x0012, 0x0032, 'LO', '1'],
        'ClinicalTrialSubjectID' => [0x0012, 0x0040, 'LO', '1'],
        'IssuerOfClinicalTrialSubjectID' => [0x0012, 0x0041, 'LO', '1'],
        'ClinicalTrialSubjectReadingID' => [0x0012, 0x0042, 'LO', '1'],
        'IssuerOfClinicalTrialSubjectReadingID' => [0x0012, 0x0043, 'LO', '1'],
        'ClinicalTrialTimePointID' => [0x0012, 0x0050, 'LO', '1'],
        'ClinicalTrialTimePointDescription' => [0x0012, 0x0051, 'ST', '1'],
        'LongitudinalTemporalOffsetFromEvent' => [0x0012, 0x0052, 'FD', '1'],
        'LongitudinalTemporalEventType' => [0x0012, 0x0053, 'CS', '1'],
        'ClinicalTrialTimePointTypeCodeSequence' => [0x0012, 0x0054, 'SQ', '1'],
        'IssuerOfClinicalTrialTimePointID' => [0x0012, 0x0055, 'LO', '1'],
        'ClinicalTrialCoordinatingCenterName' => [0x0012, 0x0060, 'LO', '1'],
        'PatientIdentityRemoved' => [0x0012, 0x0062, 'CS', '1'],
        'DeidentificationMethod' => [0x0012, 0x0063, 'LO', '1-n'],
        'DeidentificationMethodCodeSequence' => [0x0012, 0x0064, 'SQ', '1'],
        'ClinicalTrialSeriesID' => [0x0012, 0x0071, 'LO', '1'],
        'ClinicalTrialSeriesDescription' => [0x0012, 0x0072, 'LO', '1'],
        'IssuerOfClinicalTrialSeriesID' => [0x0012, 0x0073, 'LO', '1'],
        'ClinicalTrialProtocolEthicsCommitteeName' => [0x0012, 0x0081, 'LO', '1'],
        'ClinicalTrialProtocolEthicsCommitteeApprovalNumber' => [0x0012, 0x0082, 'LO', '1'],
        'ConsentForClinicalTrialUseSequence' => [0x0012, 0x0083, 'SQ', '1'],
        'DistributionType' => [0x0012, 0x0084, 'CS', '1'],
        'ConsentForDistributionFlag' => [0x0012, 0x0085, 'CS', '1'],
        'EthicsCommitteeApprovalEffectivenessStartDate' => [0x0012, 0x0086, 'DA', '1'],
        'EthicsCommitteeApprovalEffectivenessEndDate' => [0x0012, 0x0087, 'DA', '1'],
        'WhitePoint' => [0x0016, 0x0001, 'DS', '1'],
        'PrimaryChromaticities' => [0x0016, 0x0002, 'DS', '3'],
        'BatteryLevel' => [0x0016, 0x0003, 'UT', '1'],
        'ExposureTimeInSeconds' => [0x0016, 0x0004, 'DS', '1'],
        'FNumber' => [0x0016, 0x0005, 'DS', '1'],
        'OECFRows' => [0x0016, 0x0006, 'IS', '1'],
        'OECFColumns' => [0x0016, 0x0007, 'IS', '1'],
        'OECFColumnNames' => [0x0016, 0x0008, 'UC', '1-n'],
        'OECFValues' => [0x0016, 0x0009, 'DS', '1-n'],
        'SpatialFrequencyResponseRows' => [0x0016, 0x000a, 'IS', '1'],
        'SpatialFrequencyResponseColumns' => [0x0016, 0x000b, 'IS', '1'],
        'SpatialFrequencyResponseColumnNames' => [0x0016, 0x000c, 'UC', '1-n'],
        'SpatialFrequencyResponseValues' => [0x0016, 0x000d, 'DS', '1-n'],
        'ColorFilterArrayPatternRows' => [0x0016, 0x000e, 'IS', '1'],
        'ColorFilterArrayPatternColumns' => [0x0016, 0x000f, 'IS', '1'],
        'ColorFilterArrayPatternValues' => [0x0016, 0x0010, 'DS', '1-n'],
        'FlashFiringStatus' => [0x0016, 0x0011, 'US', '1'],
        'FlashReturnStatus' => [0x0016, 0x0012, 'US', '1'],
        'FlashMode' => [0x0016, 0x0013, 'US', '1'],
        'FlashFunctionPresent' => [0x0016, 0x0014, 'US', '1'],
        'FlashRedEyeMode' => [0x0016, 0x0015, 'US', '1'],
        'ExposureProgram' => [0x0016, 0x0016, 'US', '1'],
        'SpectralSensitivity' => [0x0016, 0x0017, 'UT', '1'],
        'PhotographicSensitivity' => [0x0016, 0x0018, 'IS', '1'],
        'SelfTimerMode' => [0x0016, 0x0019, 'IS', '1'],
        'SensitivityType' => [0x0016, 0x001a, 'US', '1'],
        'StandardOutputSensitivity' => [0x0016, 0x001b, 'IS', '1'],
        'RecommendedExposureIndex' => [0x0016, 0x001c, 'IS', '1'],
        'ISOSpeed' => [0x0016, 0x001d, 'IS', '1'],
        'ISOSpeedLatitudeyyy' => [0x0016, 0x001e, 'IS', '1'],
        'ISOSpeedLatitudezzz' => [0x0016, 0x001f, 'IS', '1'],
        'EXIFVersion' => [0x0016, 0x0020, 'UT', '1'],
        'ShutterSpeedValue' => [0x0016, 0x0021, 'DS', '1'],
        'ApertureValue' => [0x0016, 0x0022, 'DS', '1'],
        'BrightnessValue' => [0x0016, 0x0023, 'DS', '1'],
        'ExposureBiasValue' => [0x0016, 0x0024, 'DS', '1'],
        'MaxApertureValue' => [0x0016, 0x0025, 'DS', '1'],
        'SubjectDistance' => [0x0016, 0x0026, 'DS', '1'],
        'MeteringMode' => [0x0016, 0x0027, 'US', '1'],
        'LightSource' => [0x0016, 0x0028, 'US', '1'],
        'FocalLength' => [0x0016, 0x0029, 'DS', '1'],
        'SubjectArea' => [0x0016, 0x002a, 'IS', '2-4'],
        'MakerNote' => [0x0016, 0x002b, 'OB', '1'],
        'Temperature' => [0x0016, 0x0030, 'DS', '1'],
        'Humidity' => [0x0016, 0x0031, 'DS', '1'],
        'Pressure' => [0x0016, 0x0032, 'DS', '1'],
        'WaterDepth' => [0x0016, 0x0033, 'DS', '1'],
        'Acceleration' => [0x0016, 0x0034, 'DS', '1'],
        'CameraElevationAngle' => [0x0016, 0x0035, 'DS', '1'],
        'FlashEnergy' => [0x0016, 0x0036, 'DS', '1-2'],
        'SubjectLocation' => [0x0016, 0x0037, 'IS', '2'],
        'PhotographicExposureIndex' => [0x0016, 0x0038, 'DS', '1'],
        'SensingMethod' => [0x0016, 0x0039, 'US', '1'],
        'FileSource' => [0x0016, 0x003a, 'US', '1'],
        'SceneType' => [0x0016, 0x003b, 'US', '1'],
        'CustomRendered' => [0x0016, 0x0041, 'US', '1'],
        'ExposureMode' => [0x0016, 0x0042, 'US', '1'],
        'WhiteBalance' => [0x0016, 0x0043, 'US', '1'],
        'DigitalZoomRatio' => [0x0016, 0x0044, 'DS', '1'],
        'FocalLengthIn35mmFilm' => [0x0016, 0x0045, 'IS', '1'],
        'SceneCaptureType' => [0x0016, 0x0046, 'US', '1'],
        'GainControl' => [0x0016, 0x0047, 'US', '1'],
        'Contrast' => [0x0016, 0x0048, 'US', '1'],
        'Saturation' => [0x0016, 0x0049, 'US', '1'],
        'Sharpness' => [0x0016, 0x004a, 'US', '1'],
        'DeviceSettingDescription' => [0x0016, 0x004b, 'OB', '1'],
        'SubjectDistanceRange' => [0x0016, 0x004c, 'US', '1'],
        'CameraOwnerName' => [0x0016, 0x004d, 'UT', '1'],
        'LensSpecification' => [0x0016, 0x004e, 'DS', '4'],
        'LensMake' => [0x0016, 0x004f, 'UT', '1'],
        'LensModel' => [0x0016, 0x0050, 'UT', '1'],
        'LensSerialNumber' => [0x0016, 0x0051, 'UT', '1'],
        'InteroperabilityIndex' => [0x0016, 0x0061, 'CS', '1'],
        'InteroperabilityVersion' => [0x0016, 0x0062, 'OB', '1'],
        'GPSVersionID' => [0x0016, 0x0070, 'OB', '1'],
        'GPSLatitudeRef' => [0x0016, 0x0071, 'CS', '1'],
        'GPSLatitude' => [0x0016, 0x0072, 'DS', '3'],
        'GPSLongitudeRef' => [0x0016, 0x0073, 'CS', '1'],
        'GPSLongitude' => [0x0016, 0x0074, 'DS', '3'],
        'GPSAltitudeRef' => [0x0016, 0x0075, 'US', '1'],
        'GPSAltitude' => [0x0016, 0x0076, 'DS', '1'],
        'GPSTimeStamp' => [0x0016, 0x0077, 'DT', '1'],
        'GPSSatellites' => [0x0016, 0x0078, 'UT', '1'],
        'GPSStatus' => [0x0016, 0x0079, 'CS', '1'],
        'GPSMeasureMode' => [0x0016, 0x007a, 'CS', '1'],
        'GPSDOP' => [0x0016, 0x007b, 'DS', '1'],
        'GPSSpeedRef' => [0x0016, 0x007c, 'CS', '1'],
        'GPSSpeed' => [0x0016, 0x007d, 'DS', '1'],
        'GPSTrackRef' => [0x0016, 0x007e, 'CS', '1'],
        'GPSTrack' => [0x0016, 0x007f, 'DS', '1'],
        'GPSImgDirectionRef' => [0x0016, 0x0080, 'CS', '1'],
        'GPSImgDirection' => [0x0016, 0x0081, 'DS', '1'],
        'GPSMapDatum' => [0x0016, 0x0082, 'UT', '1'],
        'GPSDestLatitudeRef' => [0x0016, 0x0083, 'CS', '1'],
        'GPSDestLatitude' => [0x0016, 0x0084, 'DS', '3'],
        'GPSDestLongitudeRef' => [0x0016, 0x0085, 'CS', '1'],
        'GPSDestLongitude' => [0x0016, 0x0086, 'DS', '3'],
        'GPSDestBearingRef' => [0x0016, 0x0087, 'CS', '1'],
        'GPSDestBearing' => [0x0016, 0x0088, 'DS', '1'],
        'GPSDestDistanceRef' => [0x0016, 0x0089, 'CS', '1'],
        'GPSDestDistance' => [0x0016, 0x008a, 'DS', '1'],
        'GPSProcessingMethod' => [0x0016, 0x008b, 'OB', '1'],
        'GPSAreaInformation' => [0x0016, 0x008c, 'OB', '1'],
        'GPSDateStamp' => [0x0016, 0x008d, 'DT', '1'],
        'GPSDifferential' => [0x0016, 0x008e, 'IS', '1'],
        'LightSourcePolarization' => [0x0016, 0x1001, 'CS', '1'],
        'EmitterColorTemperature' => [0x0016, 0x1002, 'DS', '1'],
        'ContactMethod' => [0x0016, 0x1003, 'CS', '1'],
        'ImmersionMedia' => [0x0016, 0x1004, 'CS', '1-n'],
        'OpticalMagnificationFactor' => [0x0016, 0x1005, 'DS', '1'],
        'ContrastBolusAgent' => [0x0018, 0x0010, 'LO', '1'],
        'ContrastBolusAgentSequence' => [0x0018, 0x0012, 'SQ', '1'],
        'ContrastBolusT1Relaxivity' => [0x0018, 0x0013, 'FL', '1'],
        'ContrastBolusAdministrationRouteSequence' => [0x0018, 0x0014, 'SQ', '1'],
        'BodyPartExamined' => [0x0018, 0x0015, 'CS', '1'],
        'ScanningSequence' => [0x0018, 0x0020, 'CS', '1-n'],
        'SequenceVariant' => [0x0018, 0x0021, 'CS', '1-n'],
        'ScanOptions' => [0x0018, 0x0022, 'CS', '1-n'],
        'MRAcquisitionType' => [0x0018, 0x0023, 'CS', '1'],
        'SequenceName' => [0x0018, 0x0024, 'SH', '1'],
        'AngioFlag' => [0x0018, 0x0025, 'CS', '1'],
        'InterventionDrugInformationSequence' => [0x0018, 0x0026, 'SQ', '1'],
        'InterventionDrugStopTime' => [0x0018, 0x0027, 'TM', '1'],
        'InterventionDrugDose' => [0x0018, 0x0028, 'DS', '1'],
        'InterventionDrugCodeSequence' => [0x0018, 0x0029, 'SQ', '1'],
        'AdditionalDrugSequence' => [0x0018, 0x002a, 'SQ', '1'],
        'Radiopharmaceutical' => [0x0018, 0x0031, 'LO', '1'],
        'InterventionDrugName' => [0x0018, 0x0034, 'LO', '1'],
        'InterventionDrugStartTime' => [0x0018, 0x0035, 'TM', '1'],
        'InterventionSequence' => [0x0018, 0x0036, 'SQ', '1'],
        'InterventionStatus' => [0x0018, 0x0038, 'CS', '1'],
        'InterventionDescription' => [0x0018, 0x003a, 'ST', '1'],
        'CineRate' => [0x0018, 0x0040, 'IS', '1'],
        'InitialCineRunState' => [0x0018, 0x0042, 'CS', '1'],
        'SliceThickness' => [0x0018, 0x0050, 'DS', '1'],
        'KVP' => [0x0018, 0x0060, 'DS', '1'],
        'CountsAccumulated' => [0x0018, 0x0070, 'IS', '1'],
        'AcquisitionTerminationCondition' => [0x0018, 0x0071, 'CS', '1'],
        'EffectiveDuration' => [0x0018, 0x0072, 'DS', '1'],
        'AcquisitionStartCondition' => [0x0018, 0x0073, 'CS', '1'],
        'AcquisitionStartConditionData' => [0x0018, 0x0074, 'IS', '1'],
        'AcquisitionTerminationConditionData' => [0x0018, 0x0075, 'IS', '1'],
        'RepetitionTime' => [0x0018, 0x0080, 'DS', '1'],
        'EchoTime' => [0x0018, 0x0081, 'DS', '1'],
        'InversionTime' => [0x0018, 0x0082, 'DS', '1'],
        'NumberOfAverages' => [0x0018, 0x0083, 'DS', '1'],
        'ImagingFrequency' => [0x0018, 0x0084, 'DS', '1'],
        'ImagedNucleus' => [0x0018, 0x0085, 'SH', '1'],
        'EchoNumbers' => [0x0018, 0x0086, 'IS', '1-n'],
        'MagneticFieldStrength' => [0x0018, 0x0087, 'DS', '1'],
        'SpacingBetweenSlices' => [0x0018, 0x0088, 'DS', '1'],
        'NumberOfPhaseEncodingSteps' => [0x0018, 0x0089, 'IS', '1'],
        'DataCollectionDiameter' => [0x0018, 0x0090, 'DS', '1'],
        'EchoTrainLength' => [0x0018, 0x0091, 'IS', '1'],
        'PercentSampling' => [0x0018, 0x0093, 'DS', '1'],
        'PercentPhaseFieldOfView' => [0x0018, 0x0094, 'DS', '1'],
        'PixelBandwidth' => [0x0018, 0x0095, 'DS', '1'],
        'DeviceSerialNumber' => [0x0018, 0x1000, 'LO', '1'],
        'DeviceUID' => [0x0018, 0x1002, 'UI', '1'],
        'DeviceID' => [0x0018, 0x1003, 'LO', '1'],
        'PlateID' => [0x0018, 0x1004, 'LO', '1'],
        'GeneratorID' => [0x0018, 0x1005, 'LO', '1'],
        'GridID' => [0x0018, 0x1006, 'LO', '1'],
        'CassetteID' => [0x0018, 0x1007, 'LO', '1'],
        'GantryID' => [0x0018, 0x1008, 'LO', '1'],
        'UniqueDeviceIdentifier' => [0x0018, 0x1009, 'UT', '1'],
        'UDISequence' => [0x0018, 0x100a, 'SQ', '1'],
        'ManufacturerDeviceClassUID' => [0x0018, 0x100b, 'UI', '1-n'],
        'SecondaryCaptureDeviceID' => [0x0018, 0x1010, 'LO', '1'],
        'DateOfSecondaryCapture' => [0x0018, 0x1012, 'DA', '1'],
        'TimeOfSecondaryCapture' => [0x0018, 0x1014, 'TM', '1'],
        'SecondaryCaptureDeviceManufacturer' => [0x0018, 0x1016, 'LO', '1'],
        'SecondaryCaptureDeviceManufacturerModelName' => [0x0018, 0x1018, 'LO', '1'],
        'SecondaryCaptureDeviceSoftwareVersions' => [0x0018, 0x1019, 'LO', '1-n'],
        'SoftwareVersions' => [0x0018, 0x1020, 'LO', '1-n'],
        'VideoImageFormatAcquired' => [0x0018, 0x1022, 'SH', '1'],
        'DigitalImageFormatAcquired' => [0x0018, 0x1023, 'LO', '1'],
        'ProtocolName' => [0x0018, 0x1030, 'LO', '1'],
        'ContrastBolusRoute' => [0x0018, 0x1040, 'LO', '1'],
        'ContrastBolusVolume' => [0x0018, 0x1041, 'DS', '1'],
        'ContrastBolusStartTime' => [0x0018, 0x1042, 'TM', '1'],
        'ContrastBolusStopTime' => [0x0018, 0x1043, 'TM', '1'],
        'ContrastBolusTotalDose' => [0x0018, 0x1044, 'DS', '1'],
        'SyringeCounts' => [0x0018, 0x1045, 'IS', '1'],
        'ContrastFlowRate' => [0x0018, 0x1046, 'DS', '1-n'],
        'ContrastFlowDuration' => [0x0018, 0x1047, 'DS', '1-n'],
        'ContrastBolusIngredient' => [0x0018, 0x1048, 'CS', '1'],
        'ContrastBolusIngredientConcentration' => [0x0018, 0x1049, 'DS', '1'],
        'SpatialResolution' => [0x0018, 0x1050, 'DS', '1'],
        'TriggerTime' => [0x0018, 0x1060, 'DS', '1'],
        'TriggerSourceOrType' => [0x0018, 0x1061, 'LO', '1'],
        'NominalInterval' => [0x0018, 0x1062, 'IS', '1'],
        'FrameTime' => [0x0018, 0x1063, 'DS', '1'],
        'CardiacFramingType' => [0x0018, 0x1064, 'LO', '1'],
        'FrameTimeVector' => [0x0018, 0x1065, 'DS', '1-n'],
        'FrameDelay' => [0x0018, 0x1066, 'DS', '1'],
        'ImageTriggerDelay' => [0x0018, 0x1067, 'DS', '1'],
        'MultiplexGroupTimeOffset' => [0x0018, 0x1068, 'DS', '1'],
        'TriggerTimeOffset' => [0x0018, 0x1069, 'DS', '1'],
        'SynchronizationTrigger' => [0x0018, 0x106a, 'CS', '1'],
        'SynchronizationChannel' => [0x0018, 0x106c, 'US', '2'],
        'TriggerSamplePosition' => [0x0018, 0x106e, 'UL', '1'],
        'RadiopharmaceuticalRoute' => [0x0018, 0x1070, 'LO', '1'],
        'RadiopharmaceuticalVolume' => [0x0018, 0x1071, 'DS', '1'],
        'RadiopharmaceuticalStartTime' => [0x0018, 0x1072, 'TM', '1'],
        'RadiopharmaceuticalStopTime' => [0x0018, 0x1073, 'TM', '1'],
        'RadionuclideTotalDose' => [0x0018, 0x1074, 'DS', '1'],
        'RadionuclideHalfLife' => [0x0018, 0x1075, 'DS', '1'],
        'RadionuclidePositronFraction' => [0x0018, 0x1076, 'DS', '1'],
        'RadiopharmaceuticalSpecificActivity' => [0x0018, 0x1077, 'DS', '1'],
        'RadiopharmaceuticalStartDateTime' => [0x0018, 0x1078, 'DT', '1'],
        'RadiopharmaceuticalStopDateTime' => [0x0018, 0x1079, 'DT', '1'],
        'BeatRejectionFlag' => [0x0018, 0x1080, 'CS', '1'],
        'LowRRValue' => [0x0018, 0x1081, 'IS', '1'],
        'HighRRValue' => [0x0018, 0x1082, 'IS', '1'],
        'IntervalsAcquired' => [0x0018, 0x1083, 'IS', '1'],
        'IntervalsRejected' => [0x0018, 0x1084, 'IS', '1'],
        'PVCRejection' => [0x0018, 0x1085, 'LO', '1'],
        'SkipBeats' => [0x0018, 0x1086, 'IS', '1'],
        'HeartRate' => [0x0018, 0x1088, 'IS', '1'],
        'CardiacNumberOfImages' => [0x0018, 0x1090, 'IS', '1'],
        'TriggerWindow' => [0x0018, 0x1094, 'IS', '1'],
        'ReconstructionDiameter' => [0x0018, 0x1100, 'DS', '1'],
        'DistanceSourceToDetector' => [0x0018, 0x1110, 'DS', '1'],
        'DistanceSourceToPatient' => [0x0018, 0x1111, 'DS', '1'],
        'EstimatedRadiographicMagnificationFactor' => [0x0018, 0x1114, 'DS', '1'],
        'GantryDetectorTilt' => [0x0018, 0x1120, 'DS', '1'],
        'GantryDetectorSlew' => [0x0018, 0x1121, 'DS', '1'],
        'TableHeight' => [0x0018, 0x1130, 'DS', '1'],
        'TableTraverse' => [0x0018, 0x1131, 'DS', '1'],
        'TableMotion' => [0x0018, 0x1134, 'CS', '1'],
        'TableVerticalIncrement' => [0x0018, 0x1135, 'DS', '1-n'],
        'TableLateralIncrement' => [0x0018, 0x1136, 'DS', '1-n'],
        'TableLongitudinalIncrement' => [0x0018, 0x1137, 'DS', '1-n'],
        'TableAngle' => [0x0018, 0x1138, 'DS', '1'],
        'TableType' => [0x0018, 0x113a, 'CS', '1'],
        'RotationDirection' => [0x0018, 0x1140, 'CS', '1'],
        'RadialPosition' => [0x0018, 0x1142, 'DS', '1-n'],
        'ScanArc' => [0x0018, 0x1143, 'DS', '1'],
        'AngularStep' => [0x0018, 0x1144, 'DS', '1'],
        'CenterOfRotationOffset' => [0x0018, 0x1145, 'DS', '1'],
        'FieldOfViewShape' => [0x0018, 0x1147, 'CS', '1'],
        'FieldOfViewDimensions' => [0x0018, 0x1149, 'IS', '1-2'],
        'ExposureTime' => [0x0018, 0x1150, 'IS', '1'],
        'XRayTubeCurrent' => [0x0018, 0x1151, 'IS', '1'],
        'Exposure' => [0x0018, 0x1152, 'IS', '1'],
        'ExposureInuAs' => [0x0018, 0x1153, 'IS', '1'],
        'AveragePulseWidth' => [0x0018, 0x1154, 'DS', '1'],
        'RadiationSetting' => [0x0018, 0x1155, 'CS', '1'],
        'RectificationType' => [0x0018, 0x1156, 'CS', '1'],
        'RadiationMode' => [0x0018, 0x115a, 'CS', '1'],
        'ImageAndFluoroscopyAreaDoseProduct' => [0x0018, 0x115e, 'DS', '1'],
        'FilterType' => [0x0018, 0x1160, 'SH', '1'],
        'TypeOfFilters' => [0x0018, 0x1161, 'LO', '1-n'],
        'IntensifierSize' => [0x0018, 0x1162, 'DS', '1'],
        'ImagerPixelSpacing' => [0x0018, 0x1164, 'DS', '2'],
        'Grid' => [0x0018, 0x1166, 'CS', '1-n'],
        'GeneratorPower' => [0x0018, 0x1170, 'IS', '1'],
        'CollimatorGridName' => [0x0018, 0x1180, 'SH', '1'],
        'CollimatorType' => [0x0018, 0x1181, 'CS', '1'],
        'FocalDistance' => [0x0018, 0x1182, 'IS', '1-2'],
        'XFocusCenter' => [0x0018, 0x1183, 'DS', '1-2'],
        'YFocusCenter' => [0x0018, 0x1184, 'DS', '1-2'],
        'FocalSpots' => [0x0018, 0x1190, 'DS', '1-n'],
        'AnodeTargetMaterial' => [0x0018, 0x1191, 'CS', '1'],
        'BodyPartThickness' => [0x0018, 0x11a0, 'DS', '1'],
        'CompressionForce' => [0x0018, 0x11a2, 'DS', '1'],
        'CompressionPressure' => [0x0018, 0x11a3, 'DS', '1'],
        'PaddleDescription' => [0x0018, 0x11a4, 'LO', '1'],
        'CompressionContactArea' => [0x0018, 0x11a5, 'DS', '1'],
        'AcquisitionMode' => [0x0018, 0x11b0, 'LO', '1'],
        'DoseModeName' => [0x0018, 0x11b1, 'LO', '1'],
        'AcquiredSubtractionMaskFlag' => [0x0018, 0x11b2, 'CS', '1'],
        'FluoroscopyPersistenceFlag' => [0x0018, 0x11b3, 'CS', '1'],
        'FluoroscopyLastImageHoldPersistenceFlag' => [0x0018, 0x11b4, 'CS', '1'],
        'UpperLimitNumberOfPersistentFluoroscopyFrames' => [0x0018, 0x11b5, 'IS', '1'],
        'ContrastBolusAutoInjectionTriggerFlag' => [0x0018, 0x11b6, 'CS', '1'],
        'ContrastBolusInjectionDelay' => [0x0018, 0x11b7, 'FD', '1'],
        'XAAcquisitionPhaseDetailsSequence' => [0x0018, 0x11b8, 'SQ', '1'],
        'XAAcquisitionFrameRate' => [0x0018, 0x11b9, 'FD', '1'],
        'XAPlaneDetailsSequence' => [0x0018, 0x11ba, 'SQ', '1'],
        'AcquisitionFieldOfViewLabel' => [0x0018, 0x11bb, 'LO', '1'],
        'XRayFilterDetailsSequence' => [0x0018, 0x11bc, 'SQ', '1'],
        'XAAcquisitionDuration' => [0x0018, 0x11bd, 'FD', '1'],
        'ReconstructionPipelineType' => [0x0018, 0x11be, 'CS', '1'],
        'ImageFilterDetailsSequence' => [0x0018, 0x11bf, 'SQ', '1'],
        'AppliedMaskSubtractionFlag' => [0x0018, 0x11c0, 'CS', '1'],
        'RequestedSeriesDescriptionCodeSequence' => [0x0018, 0x11c1, 'SQ', '1'],
        'DateOfLastCalibration' => [0x0018, 0x1200, 'DA', '1-n'],
        'TimeOfLastCalibration' => [0x0018, 0x1201, 'TM', '1-n'],
        'DateTimeOfLastCalibration' => [0x0018, 0x1202, 'DT', '1'],
        'CalibrationDateTime' => [0x0018, 0x1203, 'DT', '1'],
        'DateOfManufacture' => [0x0018, 0x1204, 'DA', '1'],
        'DateOfInstallation' => [0x0018, 0x1205, 'DA', '1'],
        'ConvolutionKernel' => [0x0018, 0x1210, 'SH', '1-n'],
        'ActualFrameDuration' => [0x0018, 0x1242, 'IS', '1'],
        'CountRate' => [0x0018, 0x1243, 'IS', '1'],
        'PreferredPlaybackSequencing' => [0x0018, 0x1244, 'US', '1'],
        'ReceiveCoilName' => [0x0018, 0x1250, 'SH', '1'],
        'TransmitCoilName' => [0x0018, 0x1251, 'SH', '1'],
        'PlateType' => [0x0018, 0x1260, 'SH', '1'],
        'PhosphorType' => [0x0018, 0x1261, 'LO', '1'],
        'WaterEquivalentDiameter' => [0x0018, 0x1271, 'FD', '1'],
        'WaterEquivalentDiameterCalculationMethodCodeSequence' => [0x0018, 0x1272, 'SQ', '1'],
        'ScanVelocity' => [0x0018, 0x1300, 'DS', '1'],
        'WholeBodyTechnique' => [0x0018, 0x1301, 'CS', '1-n'],
        'ScanLength' => [0x0018, 0x1302, 'IS', '1'],
        'AcquisitionMatrix' => [0x0018, 0x1310, 'US', '4'],
        'InPlanePhaseEncodingDirection' => [0x0018, 0x1312, 'CS', '1'],
        'FlipAngle' => [0x0018, 0x1314, 'DS', '1'],
        'VariableFlipAngleFlag' => [0x0018, 0x1315, 'CS', '1'],
        'SAR' => [0x0018, 0x1316, 'DS', '1'],
        'dBdt' => [0x0018, 0x1318, 'DS', '1'],
        'B1rms' => [0x0018, 0x1320, 'FL', '1'],
        'AcquisitionDeviceProcessingDescription' => [0x0018, 0x1400, 'LO', '1'],
        'AcquisitionDeviceProcessingCode' => [0x0018, 0x1401, 'LO', '1'],
        'CassetteOrientation' => [0x0018, 0x1402, 'CS', '1'],
        'CassetteSize' => [0x0018, 0x1403, 'CS', '1'],
        'ExposuresOnPlate' => [0x0018, 0x1404, 'US', '1'],
        'RelativeXRayExposure' => [0x0018, 0x1405, 'IS', '1'],
        'ExposureIndex' => [0x0018, 0x1411, 'DS', '1'],
        'TargetExposureIndex' => [0x0018, 0x1412, 'DS', '1'],
        'DeviationIndex' => [0x0018, 0x1413, 'DS', '1'],
        'ColumnAngulation' => [0x0018, 0x1450, 'DS', '1'],
        'TomoLayerHeight' => [0x0018, 0x1460, 'DS', '1'],
        'TomoAngle' => [0x0018, 0x1470, 'DS', '1'],
        'TomoTime' => [0x0018, 0x1480, 'DS', '1'],
        'TomoType' => [0x0018, 0x1490, 'CS', '1'],
        'TomoClass' => [0x0018, 0x1491, 'CS', '1'],
        'NumberOfTomosynthesisSourceImages' => [0x0018, 0x1495, 'IS', '1'],
        'PositionerMotion' => [0x0018, 0x1500, 'CS', '1'],
        'PositionerType' => [0x0018, 0x1508, 'CS', '1'],
        'PositionerPrimaryAngle' => [0x0018, 0x1510, 'DS', '1'],
        'PositionerSecondaryAngle' => [0x0018, 0x1511, 'DS', '1'],
        'PositionerPrimaryAngleIncrement' => [0x0018, 0x1520, 'DS', '1-n'],
        'PositionerSecondaryAngleIncrement' => [0x0018, 0x1521, 'DS', '1-n'],
        'DetectorPrimaryAngle' => [0x0018, 0x1530, 'DS', '1'],
        'DetectorSecondaryAngle' => [0x0018, 0x1531, 'DS', '1'],
        'ShutterShape' => [0x0018, 0x1600, 'CS', '1-3'],
        'ShutterLeftVerticalEdge' => [0x0018, 0x1602, 'IS', '1'],
        'ShutterRightVerticalEdge' => [0x0018, 0x1604, 'IS', '1'],
        'ShutterUpperHorizontalEdge' => [0x0018, 0x1606, 'IS', '1'],
        'ShutterLowerHorizontalEdge' => [0x0018, 0x1608, 'IS', '1'],
        'CenterOfCircularShutter' => [0x0018, 0x1610, 'IS', '2'],
        'RadiusOfCircularShutter' => [0x0018, 0x1612, 'IS', '1'],
        'VerticesOfThePolygonalShutter' => [0x0018, 0x1620, 'IS', '2-2n'],
        'ShutterPresentationValue' => [0x0018, 0x1622, 'US', '1'],
        'ShutterOverlayGroup' => [0x0018, 0x1623, 'US', '1'],
        'ShutterPresentationColorCIELabValue' => [0x0018, 0x1624, 'US', '3'],
        'OutlineShapeType' => [0x0018, 0x1630, 'CS', '1'],
        'OutlineLeftVerticalEdge' => [0x0018, 0x1631, 'FD', '1'],
        'OutlineRightVerticalEdge' => [0x0018, 0x1632, 'FD', '1'],
        'OutlineUpperHorizontalEdge' => [0x0018, 0x1633, 'FD', '1'],
        'OutlineLowerHorizontalEdge' => [0x0018, 0x1634, 'FD', '1'],
        'CenterOfCircularOutline' => [0x0018, 0x1635, 'FD', '2'],
        'DiameterOfCircularOutline' => [0x0018, 0x1636, 'FD', '1'],
        'NumberOfPolygonalVertices' => [0x0018, 0x1637, 'UL', '1'],
        'VerticesOfThePolygonalOutline' => [0x0018, 0x1638, 'OF', '1'],
        'CollimatorShape' => [0x0018, 0x1700, 'CS', '1-3'],
        'CollimatorLeftVerticalEdge' => [0x0018, 0x1702, 'IS', '1'],
        'CollimatorRightVerticalEdge' => [0x0018, 0x1704, 'IS', '1'],
        'CollimatorUpperHorizontalEdge' => [0x0018, 0x1706, 'IS', '1'],
        'CollimatorLowerHorizontalEdge' => [0x0018, 0x1708, 'IS', '1'],
        'CenterOfCircularCollimator' => [0x0018, 0x1710, 'IS', '2'],
        'RadiusOfCircularCollimator' => [0x0018, 0x1712, 'IS', '1'],
        'VerticesOfThePolygonalCollimator' => [0x0018, 0x1720, 'IS', '2-2n'],
        'AcquisitionTimeSynchronized' => [0x0018, 0x1800, 'CS', '1'],
        'TimeSource' => [0x0018, 0x1801, 'SH', '1'],
        'TimeDistributionProtocol' => [0x0018, 0x1802, 'CS', '1'],
        'NTPSourceAddress' => [0x0018, 0x1803, 'LO', '1'],
        'PageNumberVector' => [0x0018, 0x2001, 'IS', '1-n'],
        'FrameLabelVector' => [0x0018, 0x2002, 'SH', '1-n'],
        'FramePrimaryAngleVector' => [0x0018, 0x2003, 'DS', '1-n'],
        'FrameSecondaryAngleVector' => [0x0018, 0x2004, 'DS', '1-n'],
        'SliceLocationVector' => [0x0018, 0x2005, 'DS', '1-n'],
        'DisplayWindowLabelVector' => [0x0018, 0x2006, 'SH', '1-n'],
        'NominalScannedPixelSpacing' => [0x0018, 0x2010, 'DS', '2'],
        'DigitizingDeviceTransportDirection' => [0x0018, 0x2020, 'CS', '1'],
        'RotationOfScannedFilm' => [0x0018, 0x2030, 'DS', '1'],
        'BiopsyTargetSequence' => [0x0018, 0x2041, 'SQ', '1'],
        'TargetUID' => [0x0018, 0x2042, 'UI', '1'],
        'LocalizingCursorPosition' => [0x0018, 0x2043, 'FL', '2'],
        'CalculatedTargetPosition' => [0x0018, 0x2044, 'FL', '3'],
        'TargetLabel' => [0x0018, 0x2045, 'SH', '1'],
        'DisplayedZValue' => [0x0018, 0x2046, 'FL', '1'],
        'IVUSAcquisition' => [0x0018, 0x3100, 'CS', '1'],
        'IVUSPullbackRate' => [0x0018, 0x3101, 'DS', '1'],
        'IVUSGatedRate' => [0x0018, 0x3102, 'DS', '1'],
        'IVUSPullbackStartFrameNumber' => [0x0018, 0x3103, 'IS', '1'],
        'IVUSPullbackStopFrameNumber' => [0x0018, 0x3104, 'IS', '1'],
        'LesionNumber' => [0x0018, 0x3105, 'IS', '1-n'],
        'OutputPower' => [0x0018, 0x5000, 'SH', '1-n'],
        'TransducerData' => [0x0018, 0x5010, 'LO', '1-n'],
        'TransducerIdentificationSequence' => [0x0018, 0x5011, 'SQ', '1'],
        'FocusDepth' => [0x0018, 0x5012, 'DS', '1'],
        'ProcessingFunction' => [0x0018, 0x5020, 'LO', '1'],
        'MechanicalIndex' => [0x0018, 0x5022, 'DS', '1'],
        'BoneThermalIndex' => [0x0018, 0x5024, 'DS', '1'],
        'CranialThermalIndex' => [0x0018, 0x5026, 'DS', '1'],
        'SoftTissueThermalIndex' => [0x0018, 0x5027, 'DS', '1'],
        'SoftTissueFocusThermalIndex' => [0x0018, 0x5028, 'DS', '1'],
        'SoftTissueSurfaceThermalIndex' => [0x0018, 0x5029, 'DS', '1'],
        'DepthOfScanField' => [0x0018, 0x5050, 'IS', '1'],
        'PatientPosition' => [0x0018, 0x5100, 'CS', '1'],
        'ViewPosition' => [0x0018, 0x5101, 'CS', '1'],
        'ProjectionEponymousNameCodeSequence' => [0x0018, 0x5104, 'SQ', '1'],
        'Sensitivity' => [0x0018, 0x6000, 'DS', '1'],
        'SequenceOfUltrasoundRegions' => [0x0018, 0x6011, 'SQ', '1'],
        'RegionSpatialFormat' => [0x0018, 0x6012, 'US', '1'],
        'RegionDataType' => [0x0018, 0x6014, 'US', '1'],
        'RegionFlags' => [0x0018, 0x6016, 'UL', '1'],
        'RegionLocationMinX0' => [0x0018, 0x6018, 'UL', '1'],
        'RegionLocationMinY0' => [0x0018, 0x601a, 'UL', '1'],
        'RegionLocationMaxX1' => [0x0018, 0x601c, 'UL', '1'],
        'RegionLocationMaxY1' => [0x0018, 0x601e, 'UL', '1'],
        'ReferencePixelX0' => [0x0018, 0x6020, 'SL', '1'],
        'ReferencePixelY0' => [0x0018, 0x6022, 'SL', '1'],
        'PhysicalUnitsXDirection' => [0x0018, 0x6024, 'US', '1'],
        'PhysicalUnitsYDirection' => [0x0018, 0x6026, 'US', '1'],
        'ReferencePixelPhysicalValueX' => [0x0018, 0x6028, 'FD', '1'],
        'ReferencePixelPhysicalValueY' => [0x0018, 0x602a, 'FD', '1'],
        'PhysicalDeltaX' => [0x0018, 0x602c, 'FD', '1'],
        'PhysicalDeltaY' => [0x0018, 0x602e, 'FD', '1'],
        'TransducerFrequency' => [0x0018, 0x6030, 'UL', '1'],
        'TransducerType' => [0x0018, 0x6031, 'CS', '1'],
        'PulseRepetitionFrequency' => [0x0018, 0x6032, 'UL', '1'],
        'DopplerCorrectionAngle' => [0x0018, 0x6034, 'FD', '1'],
        'SteeringAngle' => [0x0018, 0x6036, 'FD', '1'],
        'DopplerSampleVolumeXPosition' => [0x0018, 0x6039, 'SL', '1'],
        'DopplerSampleVolumeYPosition' => [0x0018, 0x603b, 'SL', '1'],
        'TMLinePositionX0' => [0x0018, 0x603d, 'SL', '1'],
        'TMLinePositionY0' => [0x0018, 0x603f, 'SL', '1'],
        'TMLinePositionX1' => [0x0018, 0x6041, 'SL', '1'],
        'TMLinePositionY1' => [0x0018, 0x6043, 'SL', '1'],
        'PixelComponentOrganization' => [0x0018, 0x6044, 'US', '1'],
        'PixelComponentMask' => [0x0018, 0x6046, 'UL', '1'],
        'PixelComponentRangeStart' => [0x0018, 0x6048, 'UL', '1'],
        'PixelComponentRangeStop' => [0x0018, 0x604a, 'UL', '1'],
        'PixelComponentPhysicalUnits' => [0x0018, 0x604c, 'US', '1'],
        'PixelComponentDataType' => [0x0018, 0x604e, 'US', '1'],
        'NumberOfTableBreakPoints' => [0x0018, 0x6050, 'UL', '1'],
        'TableOfXBreakPoints' => [0x0018, 0x6052, 'UL', '1-n'],
        'TableOfYBreakPoints' => [0x0018, 0x6054, 'FD', '1-n'],
        'NumberOfTableEntries' => [0x0018, 0x6056, 'UL', '1'],
        'TableOfPixelValues' => [0x0018, 0x6058, 'UL', '1-n'],
        'TableOfParameterValues' => [0x0018, 0x605a, 'FL', '1-n'],
        'RWaveTimeVector' => [0x0018, 0x6060, 'FL', '1-n'],
        'ActiveImageAreaOverlayGroup' => [0x0018, 0x6070, 'US', '1'],
        'DetectorConditionsNominalFlag' => [0x0018, 0x7000, 'CS', '1'],
        'DetectorTemperature' => [0x0018, 0x7001, 'DS', '1'],
        'DetectorType' => [0x0018, 0x7004, 'CS', '1'],
        'DetectorConfiguration' => [0x0018, 0x7005, 'CS', '1'],
        'DetectorDescription' => [0x0018, 0x7006, 'LT', '1'],
        'DetectorMode' => [0x0018, 0x7008, 'LT', '1'],
        'DetectorID' => [0x0018, 0x700a, 'SH', '1'],
        'DateOfLastDetectorCalibration' => [0x0018, 0x700c, 'DA', '1'],
        'TimeOfLastDetectorCalibration' => [0x0018, 0x700e, 'TM', '1'],
        'ExposuresOnDetectorSinceLastCalibration' => [0x0018, 0x7010, 'IS', '1'],
        'ExposuresOnDetectorSinceManufactured' => [0x0018, 0x7011, 'IS', '1'],
        'DetectorTimeSinceLastExposure' => [0x0018, 0x7012, 'DS', '1'],
        'DetectorActiveTime' => [0x0018, 0x7014, 'DS', '1'],
        'DetectorActivationOffsetFromExposure' => [0x0018, 0x7016, 'DS', '1'],
        'DetectorBinning' => [0x0018, 0x701a, 'DS', '2'],
        'DetectorElementPhysicalSize' => [0x0018, 0x7020, 'DS', '2'],
        'DetectorElementSpacing' => [0x0018, 0x7022, 'DS', '2'],
        'DetectorActiveShape' => [0x0018, 0x7024, 'CS', '1'],
        'DetectorActiveDimensions' => [0x0018, 0x7026, 'DS', '1-2'],
        'DetectorActiveOrigin' => [0x0018, 0x7028, 'DS', '2'],
        'DetectorManufacturerName' => [0x0018, 0x702a, 'LO', '1'],
        'DetectorManufacturerModelName' => [0x0018, 0x702b, 'LO', '1'],
        'FieldOfViewOrigin' => [0x0018, 0x7030, 'DS', '2'],
        'FieldOfViewRotation' => [0x0018, 0x7032, 'DS', '1'],
        'FieldOfViewHorizontalFlip' => [0x0018, 0x7034, 'CS', '1'],
        'PixelDataAreaOriginRelativeToFOV' => [0x0018, 0x7036, 'FL', '2'],
        'PixelDataAreaRotationAngleRelativeToFOV' => [0x0018, 0x7038, 'FL', '1'],
        'GridAbsorbingMaterial' => [0x0018, 0x7040, 'LT', '1'],
        'GridSpacingMaterial' => [0x0018, 0x7041, 'LT', '1'],
        'GridThickness' => [0x0018, 0x7042, 'DS', '1'],
        'GridPitch' => [0x0018, 0x7044, 'DS', '1'],
        'GridAspectRatio' => [0x0018, 0x7046, 'IS', '2'],
        'GridPeriod' => [0x0018, 0x7048, 'DS', '1'],
        'GridFocalDistance' => [0x0018, 0x704c, 'DS', '1'],
        'FilterMaterial' => [0x0018, 0x7050, 'CS', '1-n'],
        'FilterThicknessMinimum' => [0x0018, 0x7052, 'DS', '1-n'],
        'FilterThicknessMaximum' => [0x0018, 0x7054, 'DS', '1-n'],
        'FilterBeamPathLengthMinimum' => [0x0018, 0x7056, 'FL', '1-n'],
        'FilterBeamPathLengthMaximum' => [0x0018, 0x7058, 'FL', '1-n'],
        'ExposureControlMode' => [0x0018, 0x7060, 'CS', '1'],
        'ExposureControlModeDescription' => [0x0018, 0x7062, 'LT', '1'],
        'ExposureStatus' => [0x0018, 0x7064, 'CS', '1'],
        'PhototimerSetting' => [0x0018, 0x7065, 'DS', '1'],
        'ExposureTimeInuS' => [0x0018, 0x8150, 'DS', '1'],
        'XRayTubeCurrentInuA' => [0x0018, 0x8151, 'DS', '1'],
        'ContentQualification' => [0x0018, 0x9004, 'CS', '1'],
        'PulseSequenceName' => [0x0018, 0x9005, 'SH', '1'],
        'MRImagingModifierSequence' => [0x0018, 0x9006, 'SQ', '1'],
        'EchoPulseSequence' => [0x0018, 0x9008, 'CS', '1'],
        'InversionRecovery' => [0x0018, 0x9009, 'CS', '1'],
        'FlowCompensation' => [0x0018, 0x9010, 'CS', '1'],
        'MultipleSpinEcho' => [0x0018, 0x9011, 'CS', '1'],
        'MultiPlanarExcitation' => [0x0018, 0x9012, 'CS', '1'],
        'PhaseContrast' => [0x0018, 0x9014, 'CS', '1'],
        'TimeOfFlightContrast' => [0x0018, 0x9015, 'CS', '1'],
        'Spoiling' => [0x0018, 0x9016, 'CS', '1'],
        'SteadyStatePulseSequence' => [0x0018, 0x9017, 'CS', '1'],
        'EchoPlanarPulseSequence' => [0x0018, 0x9018, 'CS', '1'],
        'TagAngleFirstAxis' => [0x0018, 0x9019, 'FD', '1'],
        'MagnetizationTransfer' => [0x0018, 0x9020, 'CS', '1'],
        'T2Preparation' => [0x0018, 0x9021, 'CS', '1'],
        'BloodSignalNulling' => [0x0018, 0x9022, 'CS', '1'],
        'SaturationRecovery' => [0x0018, 0x9024, 'CS', '1'],
        'SpectrallySelectedSuppression' => [0x0018, 0x9025, 'CS', '1'],
        'SpectrallySelectedExcitation' => [0x0018, 0x9026, 'CS', '1'],
        'SpatialPresaturation' => [0x0018, 0x9027, 'CS', '1'],
        'Tagging' => [0x0018, 0x9028, 'CS', '1'],
        'OversamplingPhase' => [0x0018, 0x9029, 'CS', '1'],
        'TagSpacingFirstDimension' => [0x0018, 0x9030, 'FD', '1'],
        'GeometryOfKSpaceTraversal' => [0x0018, 0x9032, 'CS', '1'],
        'SegmentedKSpaceTraversal' => [0x0018, 0x9033, 'CS', '1'],
        'RectilinearPhaseEncodeReordering' => [0x0018, 0x9034, 'CS', '1'],
        'TagThickness' => [0x0018, 0x9035, 'FD', '1'],
        'PartialFourierDirection' => [0x0018, 0x9036, 'CS', '1'],
        'CardiacSynchronizationTechnique' => [0x0018, 0x9037, 'CS', '1'],
        'ReceiveCoilManufacturerName' => [0x0018, 0x9041, 'LO', '1'],
        'MRReceiveCoilSequence' => [0x0018, 0x9042, 'SQ', '1'],
        'ReceiveCoilType' => [0x0018, 0x9043, 'CS', '1'],
        'QuadratureReceiveCoil' => [0x0018, 0x9044, 'CS', '1'],
        'MultiCoilDefinitionSequence' => [0x0018, 0x9045, 'SQ', '1'],
        'MultiCoilConfiguration' => [0x0018, 0x9046, 'LO', '1'],
        'MultiCoilElementName' => [0x0018, 0x9047, 'SH', '1'],
        'MultiCoilElementUsed' => [0x0018, 0x9048, 'CS', '1'],
        'MRTransmitCoilSequence' => [0x0018, 0x9049, 'SQ', '1'],
        'TransmitCoilManufacturerName' => [0x0018, 0x9050, 'LO', '1'],
        'TransmitCoilType' => [0x0018, 0x9051, 'CS', '1'],
        'SpectralWidth' => [0x0018, 0x9052, 'FD', '1-2'],
        'ChemicalShiftReference' => [0x0018, 0x9053, 'FD', '1-2'],
        'VolumeLocalizationTechnique' => [0x0018, 0x9054, 'CS', '1'],
        'MRAcquisitionFrequencyEncodingSteps' => [0x0018, 0x9058, 'US', '1'],
        'Decoupling' => [0x0018, 0x9059, 'CS', '1'],
        'DecoupledNucleus' => [0x0018, 0x9060, 'CS', '1-2'],
        'DecouplingFrequency' => [0x0018, 0x9061, 'FD', '1-2'],
        'DecouplingMethod' => [0x0018, 0x9062, 'CS', '1'],
        'DecouplingChemicalShiftReference' => [0x0018, 0x9063, 'FD', '1-2'],
        'KSpaceFiltering' => [0x0018, 0x9064, 'CS', '1'],
        'TimeDomainFiltering' => [0x0018, 0x9065, 'CS', '1-2'],
        'NumberOfZeroFills' => [0x0018, 0x9066, 'US', '1-2'],
        'BaselineCorrection' => [0x0018, 0x9067, 'CS', '1'],
        'ParallelReductionFactorInPlane' => [0x0018, 0x9069, 'FD', '1'],
        'CardiacRRIntervalSpecified' => [0x0018, 0x9070, 'FD', '1'],
        'AcquisitionDuration' => [0x0018, 0x9073, 'FD', '1'],
        'FrameAcquisitionDateTime' => [0x0018, 0x9074, 'DT', '1'],
        'DiffusionDirectionality' => [0x0018, 0x9075, 'CS', '1'],
        'DiffusionGradientDirectionSequence' => [0x0018, 0x9076, 'SQ', '1'],
        'ParallelAcquisition' => [0x0018, 0x9077, 'CS', '1'],
        'ParallelAcquisitionTechnique' => [0x0018, 0x9078, 'CS', '1'],
        'InversionTimes' => [0x0018, 0x9079, 'FD', '1-n'],
        'MetaboliteMapDescription' => [0x0018, 0x9080, 'ST', '1'],
        'PartialFourier' => [0x0018, 0x9081, 'CS', '1'],
        'EffectiveEchoTime' => [0x0018, 0x9082, 'FD', '1'],
        'MetaboliteMapCodeSequence' => [0x0018, 0x9083, 'SQ', '1'],
        'ChemicalShiftSequence' => [0x0018, 0x9084, 'SQ', '1'],
        'CardiacSignalSource' => [0x0018, 0x9085, 'CS', '1'],
        'DiffusionBValue' => [0x0018, 0x9087, 'FD', '1'],
        'DiffusionGradientOrientation' => [0x0018, 0x9089, 'FD', '3'],
        'VelocityEncodingDirection' => [0x0018, 0x9090, 'FD', '3'],
        'VelocityEncodingMinimumValue' => [0x0018, 0x9091, 'FD', '1'],
        'VelocityEncodingAcquisitionSequence' => [0x0018, 0x9092, 'SQ', '1'],
        'NumberOfKSpaceTrajectories' => [0x0018, 0x9093, 'US', '1'],
        'CoverageOfKSpace' => [0x0018, 0x9094, 'CS', '1'],
        'SpectroscopyAcquisitionPhaseRows' => [0x0018, 0x9095, 'UL', '1'],
        'TransmitterFrequency' => [0x0018, 0x9098, 'FD', '1-2'],
        'ResonantNucleus' => [0x0018, 0x9100, 'CS', '1-2'],
        'FrequencyCorrection' => [0x0018, 0x9101, 'CS', '1'],
        'MRSpectroscopyFOVGeometrySequence' => [0x0018, 0x9103, 'SQ', '1'],
        'SlabThickness' => [0x0018, 0x9104, 'FD', '1'],
        'SlabOrientation' => [0x0018, 0x9105, 'FD', '3'],
        'MidSlabPosition' => [0x0018, 0x9106, 'FD', '3'],
        'MRSpatialSaturationSequence' => [0x0018, 0x9107, 'SQ', '1'],
        'MRTimingAndRelatedParametersSequence' => [0x0018, 0x9112, 'SQ', '1'],
        'MREchoSequence' => [0x0018, 0x9114, 'SQ', '1'],
        'MRModifierSequence' => [0x0018, 0x9115, 'SQ', '1'],
        'MRDiffusionSequence' => [0x0018, 0x9117, 'SQ', '1'],
        'CardiacSynchronizationSequence' => [0x0018, 0x9118, 'SQ', '1'],
        'MRAveragesSequence' => [0x0018, 0x9119, 'SQ', '1'],
        'MRFOVGeometrySequence' => [0x0018, 0x9125, 'SQ', '1'],
        'VolumeLocalizationSequence' => [0x0018, 0x9126, 'SQ', '1'],
        'SpectroscopyAcquisitionDataColumns' => [0x0018, 0x9127, 'UL', '1'],
        'DiffusionAnisotropyType' => [0x0018, 0x9147, 'CS', '1'],
        'FrameReferenceDateTime' => [0x0018, 0x9151, 'DT', '1'],
        'MRMetaboliteMapSequence' => [0x0018, 0x9152, 'SQ', '1'],
        'ParallelReductionFactorOutOfPlane' => [0x0018, 0x9155, 'FD', '1'],
        'SpectroscopyAcquisitionOutOfPlanePhaseSteps' => [0x0018, 0x9159, 'UL', '1'],
        'ParallelReductionFactorSecondInPlane' => [0x0018, 0x9168, 'FD', '1'],
        'CardiacBeatRejectionTechnique' => [0x0018, 0x9169, 'CS', '1'],
        'RespiratoryMotionCompensationTechnique' => [0x0018, 0x9170, 'CS', '1'],
        'RespiratorySignalSource' => [0x0018, 0x9171, 'CS', '1'],
        'BulkMotionCompensationTechnique' => [0x0018, 0x9172, 'CS', '1'],
        'BulkMotionSignalSource' => [0x0018, 0x9173, 'CS', '1'],
        'ApplicableSafetyStandardAgency' => [0x0018, 0x9174, 'CS', '1'],
        'ApplicableSafetyStandardDescription' => [0x0018, 0x9175, 'LO', '1'],
        'OperatingModeSequence' => [0x0018, 0x9176, 'SQ', '1'],
        'OperatingModeType' => [0x0018, 0x9177, 'CS', '1'],
        'OperatingMode' => [0x0018, 0x9178, 'CS', '1'],
        'SpecificAbsorptionRateDefinition' => [0x0018, 0x9179, 'CS', '1'],
        'GradientOutputType' => [0x0018, 0x9180, 'CS', '1'],
        'SpecificAbsorptionRateValue' => [0x0018, 0x9181, 'FD', '1'],
        'GradientOutput' => [0x0018, 0x9182, 'FD', '1'],
        'FlowCompensationDirection' => [0x0018, 0x9183, 'CS', '1'],
        'TaggingDelay' => [0x0018, 0x9184, 'FD', '1'],
        'RespiratoryMotionCompensationTechniqueDescription' => [0x0018, 0x9185, 'ST', '1'],
        'RespiratorySignalSourceID' => [0x0018, 0x9186, 'SH', '1'],
        'MRVelocityEncodingSequence' => [0x0018, 0x9197, 'SQ', '1'],
        'FirstOrderPhaseCorrection' => [0x0018, 0x9198, 'CS', '1'],
        'WaterReferencedPhaseCorrection' => [0x0018, 0x9199, 'CS', '1'],
        'MRSpectroscopyAcquisitionType' => [0x0018, 0x9200, 'CS', '1'],
        'RespiratoryCyclePosition' => [0x0018, 0x9214, 'CS', '1'],
        'VelocityEncodingMaximumValue' => [0x0018, 0x9217, 'FD', '1'],
        'TagSpacingSecondDimension' => [0x0018, 0x9218, 'FD', '1'],
        'TagAngleSecondAxis' => [0x0018, 0x9219, 'SS', '1'],
        'FrameAcquisitionDuration' => [0x0018, 0x9220, 'FD', '1'],
        'MRImageFrameTypeSequence' => [0x0018, 0x9226, 'SQ', '1'],
        'MRSpectroscopyFrameTypeSequence' => [0x0018, 0x9227, 'SQ', '1'],
        'MRAcquisitionPhaseEncodingStepsInPlane' => [0x0018, 0x9231, 'US', '1'],
        'MRAcquisitionPhaseEncodingStepsOutOfPlane' => [0x0018, 0x9232, 'US', '1'],
        'SpectroscopyAcquisitionPhaseColumns' => [0x0018, 0x9234, 'UL', '1'],
        'CardiacCyclePosition' => [0x0018, 0x9236, 'CS', '1'],
        'SpecificAbsorptionRateSequence' => [0x0018, 0x9239, 'SQ', '1'],
        'RFEchoTrainLength' => [0x0018, 0x9240, 'US', '1'],
        'GradientEchoTrainLength' => [0x0018, 0x9241, 'US', '1'],
        'ArterialSpinLabelingContrast' => [0x0018, 0x9250, 'CS', '1'],
        'MRArterialSpinLabelingSequence' => [0x0018, 0x9251, 'SQ', '1'],
        'ASLTechniqueDescription' => [0x0018, 0x9252, 'LO', '1'],
        'ASLSlabNumber' => [0x0018, 0x9253, 'US', '1'],
        'ASLSlabThickness' => [0x0018, 0x9254, 'FD', '1'],
        'ASLSlabOrientation' => [0x0018, 0x9255, 'FD', '3'],
        'ASLMidSlabPosition' => [0x0018, 0x9256, 'FD', '3'],
        'ASLContext' => [0x0018, 0x9257, 'CS', '1'],
        'ASLPulseTrainDuration' => [0x0018, 0x9258, 'UL', '1'],
        'ASLCrusherFlag' => [0x0018, 0x9259, 'CS', '1'],
        'ASLCrusherFlowLimit' => [0x0018, 0x925a, 'FD', '1'],
        'ASLCrusherDescription' => [0x0018, 0x925b, 'LO', '1'],
        'ASLBolusCutoffFlag' => [0x0018, 0x925c, 'CS', '1'],
        'ASLBolusCutoffTimingSequence' => [0x0018, 0x925d, 'SQ', '1'],
        'ASLBolusCutoffTechnique' => [0x0018, 0x925e, 'LO', '1'],
        'ASLBolusCutoffDelayTime' => [0x0018, 0x925f, 'UL', '1'],
        'ASLSlabSequence' => [0x0018, 0x9260, 'SQ', '1'],
        'ChemicalShiftMinimumIntegrationLimitInppm' => [0x0018, 0x9295, 'FD', '1'],
        'ChemicalShiftMaximumIntegrationLimitInppm' => [0x0018, 0x9296, 'FD', '1'],
        'WaterReferenceAcquisition' => [0x0018, 0x9297, 'CS', '1'],
        'EchoPeakPosition' => [0x0018, 0x9298, 'IS', '1'],
        'CTAcquisitionTypeSequence' => [0x0018, 0x9301, 'SQ', '1'],
        'AcquisitionType' => [0x0018, 0x9302, 'CS', '1'],
        'TubeAngle' => [0x0018, 0x9303, 'FD', '1'],
        'CTAcquisitionDetailsSequence' => [0x0018, 0x9304, 'SQ', '1'],
        'RevolutionTime' => [0x0018, 0x9305, 'FD', '1'],
        'SingleCollimationWidth' => [0x0018, 0x9306, 'FD', '1'],
        'TotalCollimationWidth' => [0x0018, 0x9307, 'FD', '1'],
        'CTTableDynamicsSequence' => [0x0018, 0x9308, 'SQ', '1'],
        'TableSpeed' => [0x0018, 0x9309, 'FD', '1'],
        'TableFeedPerRotation' => [0x0018, 0x9310, 'FD', '1'],
        'SpiralPitchFactor' => [0x0018, 0x9311, 'FD', '1'],
        'CTGeometrySequence' => [0x0018, 0x9312, 'SQ', '1'],
        'DataCollectionCenterPatient' => [0x0018, 0x9313, 'FD', '3'],
        'CTReconstructionSequence' => [0x0018, 0x9314, 'SQ', '1'],
        'ReconstructionAlgorithm' => [0x0018, 0x9315, 'CS', '1'],
        'ConvolutionKernelGroup' => [0x0018, 0x9316, 'CS', '1'],
        'ReconstructionFieldOfView' => [0x0018, 0x9317, 'FD', '2'],
        'ReconstructionTargetCenterPatient' => [0x0018, 0x9318, 'FD', '3'],
        'ReconstructionAngle' => [0x0018, 0x9319, 'FD', '1'],
        'ImageFilter' => [0x0018, 0x9320, 'SH', '1'],
        'CTExposureSequence' => [0x0018, 0x9321, 'SQ', '1'],
        'ReconstructionPixelSpacing' => [0x0018, 0x9322, 'FD', '2'],
        'ExposureModulationType' => [0x0018, 0x9323, 'CS', '1-n'],
        'CTXRayDetailsSequence' => [0x0018, 0x9325, 'SQ', '1'],
        'CTPositionSequence' => [0x0018, 0x9326, 'SQ', '1'],
        'TablePosition' => [0x0018, 0x9327, 'FD', '1'],
        'ExposureTimeInms' => [0x0018, 0x9328, 'FD', '1'],
        'CTImageFrameTypeSequence' => [0x0018, 0x9329, 'SQ', '1'],
        'XRayTubeCurrentInmA' => [0x0018, 0x9330, 'FD', '1'],
        'ExposureInmAs' => [0x0018, 0x9332, 'FD', '1'],
        'ConstantVolumeFlag' => [0x0018, 0x9333, 'CS', '1'],
        'FluoroscopyFlag' => [0x0018, 0x9334, 'CS', '1'],
        'DistanceSourceToDataCollectionCenter' => [0x0018, 0x9335, 'FD', '1'],
        'ContrastBolusAgentNumber' => [0x0018, 0x9337, 'US', '1'],
        'ContrastBolusIngredientCodeSequence' => [0x0018, 0x9338, 'SQ', '1'],
        'ContrastAdministrationProfileSequence' => [0x0018, 0x9340, 'SQ', '1'],
        'ContrastBolusUsageSequence' => [0x0018, 0x9341, 'SQ', '1'],
        'ContrastBolusAgentAdministered' => [0x0018, 0x9342, 'CS', '1'],
        'ContrastBolusAgentDetected' => [0x0018, 0x9343, 'CS', '1'],
        'ContrastBolusAgentPhase' => [0x0018, 0x9344, 'CS', '1'],
        'CTDIvol' => [0x0018, 0x9345, 'FD', '1'],
        'CTDIPhantomTypeCodeSequence' => [0x0018, 0x9346, 'SQ', '1'],
        'CalciumScoringMassFactorPatient' => [0x0018, 0x9351, 'FL', '1'],
        'CalciumScoringMassFactorDevice' => [0x0018, 0x9352, 'FL', '3'],
        'EnergyWeightingFactor' => [0x0018, 0x9353, 'FL', '1'],
        'CTAdditionalXRaySourceSequence' => [0x0018, 0x9360, 'SQ', '1'],
        'MultienergyCTAcquisition' => [0x0018, 0x9361, 'CS', '1'],
        'MultienergyCTAcquisitionSequence' => [0x0018, 0x9362, 'SQ', '1'],
        'MultienergyCTProcessingSequence' => [0x0018, 0x9363, 'SQ', '1'],
        'MultienergyCTCharacteristicsSequence' => [0x0018, 0x9364, 'SQ', '1'],
        'MultienergyCTXRaySourceSequence' => [0x0018, 0x9365, 'SQ', '1'],
        'XRaySourceIndex' => [0x0018, 0x9366, 'US', '1'],
        'XRaySourceID' => [0x0018, 0x9367, 'UC', '1'],
        'MultienergySourceTechnique' => [0x0018, 0x9368, 'CS', '1'],
        'SourceStartDateTime' => [0x0018, 0x9369, 'DT', '1'],
        'SourceEndDateTime' => [0x0018, 0x936a, 'DT', '1'],
        'SwitchingPhaseNumber' => [0x0018, 0x936b, 'US', '1'],
        'SwitchingPhaseNominalDuration' => [0x0018, 0x936c, 'DS', '1'],
        'SwitchingPhaseTransitionDuration' => [0x0018, 0x936d, 'DS', '1'],
        'EffectiveBinEnergy' => [0x0018, 0x936e, 'DS', '1'],
        'MultienergyCTXRayDetectorSequence' => [0x0018, 0x936f, 'SQ', '1'],
        'XRayDetectorIndex' => [0x0018, 0x9370, 'US', '1'],
        'XRayDetectorID' => [0x0018, 0x9371, 'UC', '1'],
        'MultienergyDetectorType' => [0x0018, 0x9372, 'CS', '1'],
        'XRayDetectorLabel' => [0x0018, 0x9373, 'ST', '1'],
        'NominalMaxEnergy' => [0x0018, 0x9374, 'DS', '1'],
        'NominalMinEnergy' => [0x0018, 0x9375, 'DS', '1'],
        'ReferencedXRayDetectorIndex' => [0x0018, 0x9376, 'US', '1-n'],
        'ReferencedXRaySourceIndex' => [0x0018, 0x9377, 'US', '1-n'],
        'ReferencedPathIndex' => [0x0018, 0x9378, 'US', '1-n'],
        'MultienergyCTPathSequence' => [0x0018, 0x9379, 'SQ', '1'],
        'MultienergyCTPathIndex' => [0x0018, 0x937a, 'US', '1'],
        'MultienergyAcquisitionDescription' => [0x0018, 0x937b, 'UT', '1'],
        'MonoenergeticEnergyEquivalent' => [0x0018, 0x937c, 'FD', '1'],
        'MaterialCodeSequence' => [0x0018, 0x937d, 'SQ', '1'],
        'DecompositionMethod' => [0x0018, 0x937e, 'CS', '1'],
        'DecompositionDescription' => [0x0018, 0x937f, 'UT', '1'],
        'DecompositionAlgorithmIdentificationSequence' => [0x0018, 0x9380, 'SQ', '1'],
        'DecompositionMaterialSequence' => [0x0018, 0x9381, 'SQ', '1'],
        'MaterialAttenuationSequence' => [0x0018, 0x9382, 'SQ', '1'],
        'PhotonEnergy' => [0x0018, 0x9383, 'DS', '1'],
        'XRayMassAttenuationCoefficient' => [0x0018, 0x9384, 'DS', '1'],
        'MetalArtifactReductionSequence' => [0x0018, 0x9390, 'SQ', '1'],
        'MetalArtifactReductionApplied' => [0x0018, 0x9391, 'CS', '1'],
        'MetalArtifactReductionAlgorithmIdentificationSequence' => [0x0018, 0x9392, 'SQ', '1'],
        'ProjectionPixelCalibrationSequence' => [0x0018, 0x9401, 'SQ', '1'],
        'DistanceSourceToIsocenter' => [0x0018, 0x9402, 'FL', '1'],
        'DistanceObjectToTableTop' => [0x0018, 0x9403, 'FL', '1'],
        'ObjectPixelSpacingInCenterOfBeam' => [0x0018, 0x9404, 'FL', '2'],
        'PositionerPositionSequence' => [0x0018, 0x9405, 'SQ', '1'],
        'TablePositionSequence' => [0x0018, 0x9406, 'SQ', '1'],
        'CollimatorShapeSequence' => [0x0018, 0x9407, 'SQ', '1'],
        'PlanesInAcquisition' => [0x0018, 0x9410, 'CS', '1'],
        'XAXRFFrameCharacteristicsSequence' => [0x0018, 0x9412, 'SQ', '1'],
        'FrameAcquisitionSequence' => [0x0018, 0x9417, 'SQ', '1'],
        'XRayReceptorType' => [0x0018, 0x9420, 'CS', '1'],
        'AcquisitionProtocolName' => [0x0018, 0x9423, 'LO', '1'],
        'AcquisitionProtocolDescription' => [0x0018, 0x9424, 'LT', '1'],
        'ContrastBolusIngredientOpaque' => [0x0018, 0x9425, 'CS', '1'],
        'DistanceReceptorPlaneToDetectorHousing' => [0x0018, 0x9426, 'FL', '1'],
        'IntensifierActiveShape' => [0x0018, 0x9427, 'CS', '1'],
        'IntensifierActiveDimensions' => [0x0018, 0x9428, 'FL', '1-2'],
        'PhysicalDetectorSize' => [0x0018, 0x9429, 'FL', '2'],
        'PositionOfIsocenterProjection' => [0x0018, 0x9430, 'FL', '2'],
        'FieldOfViewSequence' => [0x0018, 0x9432, 'SQ', '1'],
        'FieldOfViewDescription' => [0x0018, 0x9433, 'LO', '1'],
        'ExposureControlSensingRegionsSequence' => [0x0018, 0x9434, 'SQ', '1'],
        'ExposureControlSensingRegionShape' => [0x0018, 0x9435, 'CS', '1'],
        'ExposureControlSensingRegionLeftVerticalEdge' => [0x0018, 0x9436, 'SS', '1'],
        'ExposureControlSensingRegionRightVerticalEdge' => [0x0018, 0x9437, 'SS', '1'],
        'ExposureControlSensingRegionUpperHorizontalEdge' => [0x0018, 0x9438, 'SS', '1'],
        'ExposureControlSensingRegionLowerHorizontalEdge' => [0x0018, 0x9439, 'SS', '1'],
        'CenterOfCircularExposureControlSensingRegion' => [0x0018, 0x9440, 'SS', '2'],
        'RadiusOfCircularExposureControlSensingRegion' => [0x0018, 0x9441, 'US', '1'],
        'VerticesOfThePolygonalExposureControlSensingRegion' => [0x0018, 0x9442, 'SS', '2-n'],
        'ColumnAngulationPatient' => [0x0018, 0x9447, 'FL', '1'],
        'BeamAngle' => [0x0018, 0x9449, 'FL', '1'],
        'FrameDetectorParametersSequence' => [0x0018, 0x9451, 'SQ', '1'],
        'CalculatedAnatomyThickness' => [0x0018, 0x9452, 'FL', '1'],
        'CalibrationSequence' => [0x0018, 0x9455, 'SQ', '1'],
        'ObjectThicknessSequence' => [0x0018, 0x9456, 'SQ', '1'],
        'PlaneIdentification' => [0x0018, 0x9457, 'CS', '1'],
        'FieldOfViewDimensionsInFloat' => [0x0018, 0x9461, 'FL', '1-2'],
        'IsocenterReferenceSystemSequence' => [0x0018, 0x9462, 'SQ', '1'],
        'PositionerIsocenterPrimaryAngle' => [0x0018, 0x9463, 'FL', '1'],
        'PositionerIsocenterSecondaryAngle' => [0x0018, 0x9464, 'FL', '1'],
        'PositionerIsocenterDetectorRotationAngle' => [0x0018, 0x9465, 'FL', '1'],
        'TableXPositionToIsocenter' => [0x0018, 0x9466, 'FL', '1'],
        'TableYPositionToIsocenter' => [0x0018, 0x9467, 'FL', '1'],
        'TableZPositionToIsocenter' => [0x0018, 0x9468, 'FL', '1'],
        'TableHorizontalRotationAngle' => [0x0018, 0x9469, 'FL', '1'],
        'TableHeadTiltAngle' => [0x0018, 0x9470, 'FL', '1'],
        'TableCradleTiltAngle' => [0x0018, 0x9471, 'FL', '1'],
        'FrameDisplayShutterSequence' => [0x0018, 0x9472, 'SQ', '1'],
        'AcquiredImageAreaDoseProduct' => [0x0018, 0x9473, 'FL', '1'],
        'CArmPositionerTabletopRelationship' => [0x0018, 0x9474, 'CS', '1'],
        'XRayGeometrySequence' => [0x0018, 0x9476, 'SQ', '1'],
        'IrradiationEventIdentificationSequence' => [0x0018, 0x9477, 'SQ', '1'],
        'XRay3DFrameTypeSequence' => [0x0018, 0x9504, 'SQ', '1'],
        'ContributingSourcesSequence' => [0x0018, 0x9506, 'SQ', '1'],
        'XRay3DAcquisitionSequence' => [0x0018, 0x9507, 'SQ', '1'],
        'PrimaryPositionerScanArc' => [0x0018, 0x9508, 'FL', '1'],
        'SecondaryPositionerScanArc' => [0x0018, 0x9509, 'FL', '1'],
        'PrimaryPositionerScanStartAngle' => [0x0018, 0x9510, 'FL', '1'],
        'SecondaryPositionerScanStartAngle' => [0x0018, 0x9511, 'FL', '1'],
        'PrimaryPositionerIncrement' => [0x0018, 0x9514, 'FL', '1'],
        'SecondaryPositionerIncrement' => [0x0018, 0x9515, 'FL', '1'],
        'StartAcquisitionDateTime' => [0x0018, 0x9516, 'DT', '1'],
        'EndAcquisitionDateTime' => [0x0018, 0x9517, 'DT', '1'],
        'PrimaryPositionerIncrementSign' => [0x0018, 0x9518, 'SS', '1'],
        'SecondaryPositionerIncrementSign' => [0x0018, 0x9519, 'SS', '1'],
        'ApplicationName' => [0x0018, 0x9524, 'LO', '1'],
        'ApplicationVersion' => [0x0018, 0x9525, 'LO', '1'],
        'ApplicationManufacturer' => [0x0018, 0x9526, 'LO', '1'],
        'AlgorithmType' => [0x0018, 0x9527, 'CS', '1'],
        'AlgorithmDescription' => [0x0018, 0x9528, 'LO', '1'],
        'XRay3DReconstructionSequence' => [0x0018, 0x9530, 'SQ', '1'],
        'ReconstructionDescription' => [0x0018, 0x9531, 'LO', '1'],
        'PerProjectionAcquisitionSequence' => [0x0018, 0x9538, 'SQ', '1'],
        'DetectorPositionSequence' => [0x0018, 0x9541, 'SQ', '1'],
        'XRayAcquisitionDoseSequence' => [0x0018, 0x9542, 'SQ', '1'],
        'XRaySourceIsocenterPrimaryAngle' => [0x0018, 0x9543, 'FD', '1'],
        'XRaySourceIsocenterSecondaryAngle' => [0x0018, 0x9544, 'FD', '1'],
        'BreastSupportIsocenterPrimaryAngle' => [0x0018, 0x9545, 'FD', '1'],
        'BreastSupportIsocenterSecondaryAngle' => [0x0018, 0x9546, 'FD', '1'],
        'BreastSupportXPositionToIsocenter' => [0x0018, 0x9547, 'FD', '1'],
        'BreastSupportYPositionToIsocenter' => [0x0018, 0x9548, 'FD', '1'],
        'BreastSupportZPositionToIsocenter' => [0x0018, 0x9549, 'FD', '1'],
        'DetectorIsocenterPrimaryAngle' => [0x0018, 0x9550, 'FD', '1'],
        'DetectorIsocenterSecondaryAngle' => [0x0018, 0x9551, 'FD', '1'],
        'DetectorXPositionToIsocenter' => [0x0018, 0x9552, 'FD', '1'],
        'DetectorYPositionToIsocenter' => [0x0018, 0x9553, 'FD', '1'],
        'DetectorZPositionToIsocenter' => [0x0018, 0x9554, 'FD', '1'],
        'XRayGridSequence' => [0x0018, 0x9555, 'SQ', '1'],
        'XRayFilterSequence' => [0x0018, 0x9556, 'SQ', '1'],
        'DetectorActiveAreaTLHCPosition' => [0x0018, 0x9557, 'FD', '3'],
        'DetectorActiveAreaOrientation' => [0x0018, 0x9558, 'FD', '6'],
        'PositionerPrimaryAngleDirection' => [0x0018, 0x9559, 'CS', '1'],
        'DiffusionBMatrixSequence' => [0x0018, 0x9601, 'SQ', '1'],
        'DiffusionBValueXX' => [0x0018, 0x9602, 'FD', '1'],
        'DiffusionBValueXY' => [0x0018, 0x9603, 'FD', '1'],
        'DiffusionBValueXZ' => [0x0018, 0x9604, 'FD', '1'],
        'DiffusionBValueYY' => [0x0018, 0x9605, 'FD', '1'],
        'DiffusionBValueYZ' => [0x0018, 0x9606, 'FD', '1'],
        'DiffusionBValueZZ' => [0x0018, 0x9607, 'FD', '1'],
        'FunctionalMRSequence' => [0x0018, 0x9621, 'SQ', '1'],
        'FunctionalSettlingPhaseFramesPresent' => [0x0018, 0x9622, 'CS', '1'],
        'FunctionalSyncPulse' => [0x0018, 0x9623, 'DT', '1'],
        'SettlingPhaseFrame' => [0x0018, 0x9624, 'CS', '1'],
        'DecayCorrectionDateTime' => [0x0018, 0x9701, 'DT', '1'],
        'StartDensityThreshold' => [0x0018, 0x9715, 'FD', '1'],
        'StartRelativeDensityDifferenceThreshold' => [0x0018, 0x9716, 'FD', '1'],
        'StartCardiacTriggerCountThreshold' => [0x0018, 0x9717, 'FD', '1'],
        'StartRespiratoryTriggerCountThreshold' => [0x0018, 0x9718, 'FD', '1'],
        'TerminationCountsThreshold' => [0x0018, 0x9719, 'FD', '1'],
        'TerminationDensityThreshold' => [0x0018, 0x9720, 'FD', '1'],
        'TerminationRelativeDensityThreshold' => [0x0018, 0x9721, 'FD', '1'],
        'TerminationTimeThreshold' => [0x0018, 0x9722, 'FD', '1'],
        'TerminationCardiacTriggerCountThreshold' => [0x0018, 0x9723, 'FD', '1'],
        'TerminationRespiratoryTriggerCountThreshold' => [0x0018, 0x9724, 'FD', '1'],
        'DetectorGeometry' => [0x0018, 0x9725, 'CS', '1'],
        'TransverseDetectorSeparation' => [0x0018, 0x9726, 'FD', '1'],
        'AxialDetectorDimension' => [0x0018, 0x9727, 'FD', '1'],
        'RadiopharmaceuticalAgentNumber' => [0x0018, 0x9729, 'US', '1'],
        'PETFrameAcquisitionSequence' => [0x0018, 0x9732, 'SQ', '1'],
        'PETDetectorMotionDetailsSequence' => [0x0018, 0x9733, 'SQ', '1'],
        'PETTableDynamicsSequence' => [0x0018, 0x9734, 'SQ', '1'],
        'PETPositionSequence' => [0x0018, 0x9735, 'SQ', '1'],
        'PETFrameCorrectionFactorsSequence' => [0x0018, 0x9736, 'SQ', '1'],
        'RadiopharmaceuticalUsageSequence' => [0x0018, 0x9737, 'SQ', '1'],
        'AttenuationCorrectionSource' => [0x0018, 0x9738, 'CS', '1'],
        'NumberOfIterations' => [0x0018, 0x9739, 'US', '1'],
        'NumberOfSubsets' => [0x0018, 0x9740, 'US', '1'],
        'PETReconstructionSequence' => [0x0018, 0x9749, 'SQ', '1'],
        'PETFrameTypeSequence' => [0x0018, 0x9751, 'SQ', '1'],
        'TimeOfFlightInformationUsed' => [0x0018, 0x9755, 'CS', '1'],
        'ReconstructionType' => [0x0018, 0x9756, 'CS', '1'],
        'DecayCorrected' => [0x0018, 0x9758, 'CS', '1'],
        'AttenuationCorrected' => [0x0018, 0x9759, 'CS', '1'],
        'ScatterCorrected' => [0x0018, 0x9760, 'CS', '1'],
        'DeadTimeCorrected' => [0x0018, 0x9761, 'CS', '1'],
        'GantryMotionCorrected' => [0x0018, 0x9762, 'CS', '1'],
        'PatientMotionCorrected' => [0x0018, 0x9763, 'CS', '1'],
        'CountLossNormalizationCorrected' => [0x0018, 0x9764, 'CS', '1'],
        'RandomsCorrected' => [0x0018, 0x9765, 'CS', '1'],
        'NonUniformRadialSamplingCorrected' => [0x0018, 0x9766, 'CS', '1'],
        'SensitivityCalibrated' => [0x0018, 0x9767, 'CS', '1'],
        'DetectorNormalizationCorrection' => [0x0018, 0x9768, 'CS', '1'],
        'IterativeReconstructionMethod' => [0x0018, 0x9769, 'CS', '1'],
        'AttenuationCorrectionTemporalRelationship' => [0x0018, 0x9770, 'CS', '1'],
        'PatientPhysiologicalStateSequence' => [0x0018, 0x9771, 'SQ', '1'],
        'PatientPhysiologicalStateCodeSequence' => [0x0018, 0x9772, 'SQ', '1'],
        'DepthsOfFocus' => [0x0018, 0x9801, 'FD', '1-n'],
        'ExcludedIntervalsSequence' => [0x0018, 0x9803, 'SQ', '1'],
        'ExclusionStartDateTime' => [0x0018, 0x9804, 'DT', '1'],
        'ExclusionDuration' => [0x0018, 0x9805, 'FD', '1'],
        'USImageDescriptionSequence' => [0x0018, 0x9806, 'SQ', '1'],
        'ImageDataTypeSequence' => [0x0018, 0x9807, 'SQ', '1'],
        'DataType' => [0x0018, 0x9808, 'CS', '1'],
        'TransducerScanPatternCodeSequence' => [0x0018, 0x9809, 'SQ', '1'],
        'AliasedDataType' => [0x0018, 0x980b, 'CS', '1'],
        'PositionMeasuringDeviceUsed' => [0x0018, 0x980c, 'CS', '1'],
        'TransducerGeometryCodeSequence' => [0x0018, 0x980d, 'SQ', '1'],
        'TransducerBeamSteeringCodeSequence' => [0x0018, 0x980e, 'SQ', '1'],
        'TransducerApplicationCodeSequence' => [0x0018, 0x980f, 'SQ', '1'],
        'ZeroVelocityPixelValue' => [0x0018, 0x9810, 'xs', '1'],
        'PhotoacousticExcitationCharacteristicsSequence' => [0x0018, 0x9821, 'SQ', '1'],
        'ExcitationSpectralWidth' => [0x0018, 0x9822, 'FD', '1'],
        'ExcitationEnergy' => [0x0018, 0x9823, 'FD', '1'],
        'ExcitationPulseDuration' => [0x0018, 0x9824, 'FD', '1'],
        'ExcitationWavelengthSequence' => [0x0018, 0x9825, 'SQ', '1'],
        'ExcitationWavelength' => [0x0018, 0x9826, 'FD', '1'],
        'IlluminationTranslationFlag' => [0x0018, 0x9828, 'CS', '1'],
        'AcousticCouplingMediumFlag' => [0x0018, 0x9829, 'CS', '1'],
        'AcousticCouplingMediumCodeSequence' => [0x0018, 0x982a, 'SQ', '1'],
        'AcousticCouplingMediumTemperature' => [0x0018, 0x982b, 'FD', '1'],
        'TransducerResponseSequence' => [0x0018, 0x982c, 'SQ', '1'],
        'CenterFrequency' => [0x0018, 0x982d, 'FD', '1'],
        'FractionalBandwidth' => [0x0018, 0x982e, 'FD', '1'],
        'LowerCutoffFrequency' => [0x0018, 0x982f, 'FD', '1'],
        'UpperCutoffFrequency' => [0x0018, 0x9830, 'FD', '1'],
        'TransducerTechnologySequence' => [0x0018, 0x9831, 'SQ', '1'],
        'SoundSpeedCorrectionMechanismCodeSequence' => [0x0018, 0x9832, 'SQ', '1'],
        'ObjectSoundSpeed' => [0x0018, 0x9833, 'FD', '1'],
        'AcousticCouplingMediumSoundSpeed' => [0x0018, 0x9834, 'FD', '1'],
        'PhotoacousticImageFrameTypeSequence' => [0x0018, 0x9835, 'SQ', '1'],
        'ImageDataTypeCodeSequence' => [0x0018, 0x9836, 'SQ', '1'],
        'ReferenceLocationLabel' => [0x0018, 0x9900, 'LO', '1'],
        'ReferenceLocationDescription' => [0x0018, 0x9901, 'UT', '1'],
        'ReferenceBasisCodeSequence' => [0x0018, 0x9902, 'SQ', '1'],
        'ReferenceGeometryCodeSequence' => [0x0018, 0x9903, 'SQ', '1'],
        'OffsetDistance' => [0x0018, 0x9904, 'DS', '1'],
        'OffsetDirection' => [0x0018, 0x9905, 'CS', '1'],
        'PotentialScheduledProtocolCodeSequence' => [0x0018, 0x9906, 'SQ', '1'],
        'PotentialRequestedProcedureCodeSequence' => [0x0018, 0x9907, 'SQ', '1'],
        'PotentialReasonsForProcedure' => [0x0018, 0x9908, 'UC', '1-n'],
        'PotentialReasonsForProcedureCodeSequence' => [0x0018, 0x9909, 'SQ', '1'],
        'PotentialDiagnosticTasks' => [0x0018, 0x990a, 'UC', '1-n'],
        'ContraindicationsCodeSequence' => [0x0018, 0x990b, 'SQ', '1'],
        'ReferencedDefinedProtocolSequence' => [0x0018, 0x990c, 'SQ', '1'],
        'ReferencedPerformedProtocolSequence' => [0x0018, 0x990d, 'SQ', '1'],
        'PredecessorProtocolSequence' => [0x0018, 0x990e, 'SQ', '1'],
        'ProtocolPlanningInformation' => [0x0018, 0x990f, 'UT', '1'],
        'ProtocolDesignRationale' => [0x0018, 0x9910, 'UT', '1'],
        'PatientSpecificationSequence' => [0x0018, 0x9911, 'SQ', '1'],
        'ModelSpecificationSequence' => [0x0018, 0x9912, 'SQ', '1'],
        'ParametersSpecificationSequence' => [0x0018, 0x9913, 'SQ', '1'],
        'InstructionSequence' => [0x0018, 0x9914, 'SQ', '1'],
        'InstructionIndex' => [0x0018, 0x9915, 'US', '1'],
        'InstructionText' => [0x0018, 0x9916, 'LO', '1'],
        'InstructionDescription' => [0x0018, 0x9917, 'UT', '1'],
        'InstructionPerformedFlag' => [0x0018, 0x9918, 'CS', '1'],
        'InstructionPerformedDateTime' => [0x0018, 0x9919, 'DT', '1'],
        'InstructionPerformanceComment' => [0x0018, 0x991a, 'UT', '1'],
        'PatientPositioningInstructionSequence' => [0x0018, 0x991b, 'SQ', '1'],
        'PositioningMethodCodeSequence' => [0x0018, 0x991c, 'SQ', '1'],
        'PositioningLandmarkSequence' => [0x0018, 0x991d, 'SQ', '1'],
        'TargetFrameOfReferenceUID' => [0x0018, 0x991e, 'UI', '1'],
        'AcquisitionProtocolElementSpecificationSequence' => [0x0018, 0x991f, 'SQ', '1'],
        'AcquisitionProtocolElementSequence' => [0x0018, 0x9920, 'SQ', '1'],
        'ProtocolElementNumber' => [0x0018, 0x9921, 'US', '1'],
        'ProtocolElementName' => [0x0018, 0x9922, 'LO', '1'],
        'ProtocolElementCharacteristicsSummary' => [0x0018, 0x9923, 'UT', '1'],
        'ProtocolElementPurpose' => [0x0018, 0x9924, 'UT', '1'],
        'AcquisitionMotion' => [0x0018, 0x9930, 'CS', '1'],
        'AcquisitionStartLocationSequence' => [0x0018, 0x9931, 'SQ', '1'],
        'AcquisitionEndLocationSequence' => [0x0018, 0x9932, 'SQ', '1'],
        'ReconstructionProtocolElementSpecificationSequence' => [0x0018, 0x9933, 'SQ', '1'],
        'ReconstructionProtocolElementSequence' => [0x0018, 0x9934, 'SQ', '1'],
        'StorageProtocolElementSpecificationSequence' => [0x0018, 0x9935, 'SQ', '1'],
        'StorageProtocolElementSequence' => [0x0018, 0x9936, 'SQ', '1'],
        'RequestedSeriesDescription' => [0x0018, 0x9937, 'LO', '1'],
        'SourceAcquisitionProtocolElementNumber' => [0x0018, 0x9938, 'US', '1-n'],
        'SourceAcquisitionBeamNumber' => [0x0018, 0x9939, 'US', '1-n'],
        'SourceReconstructionProtocolElementNumber' => [0x0018, 0x993a, 'US', '1-n'],
        'ReconstructionStartLocationSequence' => [0x0018, 0x993b, 'SQ', '1'],
        'ReconstructionEndLocationSequence' => [0x0018, 0x993c, 'SQ', '1'],
        'ReconstructionAlgorithmSequence' => [0x0018, 0x993d, 'SQ', '1'],
        'ReconstructionTargetCenterLocationSequence' => [0x0018, 0x993e, 'SQ', '1'],
        'ImageFilterDescription' => [0x0018, 0x9941, 'UT', '1'],
        'CTDIvolNotificationTrigger' => [0x0018, 0x9942, 'FD', '1'],
        'DLPNotificationTrigger' => [0x0018, 0x9943, 'FD', '1'],
        'AutoKVPSelectionType' => [0x0018, 0x9944, 'CS', '1'],
        'AutoKVPUpperBound' => [0x0018, 0x9945, 'FD', '1'],
        'AutoKVPLowerBound' => [0x0018, 0x9946, 'FD', '1'],
        'ProtocolDefinedPatientPosition' => [0x0018, 0x9947, 'CS', '1'],
        'ContributingEquipmentSequence' => [0x0018, 0xa001, 'SQ', '1'],
        'ContributionDateTime' => [0x0018, 0xa002, 'DT', '1'],
        'ContributionDescription' => [0x0018, 0xa003, 'ST', '1'],
        'StudyInstanceUID' => [0x0020, 0x000d, 'UI', '1'],
        'SeriesInstanceUID' => [0x0020, 0x000e, 'UI', '1'],
        'StudyID' => [0x0020, 0x0010, 'SH', '1'],
        'SeriesNumber' => [0x0020, 0x0011, 'IS', '1'],
        'AcquisitionNumber' => [0x0020, 0x0012, 'IS', '1'],
        'InstanceNumber' => [0x0020, 0x0013, 'IS', '1'],
        'ItemNumber' => [0x0020, 0x0019, 'IS', '1'],
        'PatientOrientation' => [0x0020, 0x0020, 'CS', '2'],
        'PyramidLabel' => [0x0020, 0x0027, 'LO', '1'],
        'ImagePositionPatient' => [0x0020, 0x0032, 'DS', '3'],
        'ImageOrientationPatient' => [0x0020, 0x0037, 'DS', '6'],
        'FrameOfReferenceUID' => [0x0020, 0x0052, 'UI', '1'],
        'Laterality' => [0x0020, 0x0060, 'CS', '1'],
        'ImageLaterality' => [0x0020, 0x0062, 'CS', '1'],
        'TemporalPositionIdentifier' => [0x0020, 0x0100, 'IS', '1'],
        'NumberOfTemporalPositions' => [0x0020, 0x0105, 'IS', '1'],
        'TemporalResolution' => [0x0020, 0x0110, 'DS', '1'],
        'SynchronizationFrameOfReferenceUID' => [0x0020, 0x0200, 'UI', '1'],
        'SOPInstanceUIDOfConcatenationSource' => [0x0020, 0x0242, 'UI', '1'],
        'ImagesInAcquisition' => [0x0020, 0x1002, 'IS', '1'],
        'TargetPositionReferenceIndicator' => [0x0020, 0x103f, 'LO', '1'],
        'PositionReferenceIndicator' => [0x0020, 0x1040, 'LO', '1'],
        'SliceLocation' => [0x0020, 0x1041, 'DS', '1'],
        'NumberOfPatientRelatedStudies' => [0x0020, 0x1200, 'IS', '1'],
        'NumberOfPatientRelatedSeries' => [0x0020, 0x1202, 'IS', '1'],
        'NumberOfPatientRelatedInstances' => [0x0020, 0x1204, 'IS', '1'],
        'NumberOfStudyRelatedSeries' => [0x0020, 0x1206, 'IS', '1'],
        'NumberOfStudyRelatedInstances' => [0x0020, 0x1208, 'IS', '1'],
        'NumberOfSeriesRelatedInstances' => [0x0020, 0x1209, 'IS', '1'],
        'ImageComments' => [0x0020, 0x4000, 'LT', '1'],
        'StackID' => [0x0020, 0x9056, 'SH', '1'],
        'InStackPositionNumber' => [0x0020, 0x9057, 'UL', '1'],
        'FrameAnatomySequence' => [0x0020, 0x9071, 'SQ', '1'],
        'FrameLaterality' => [0x0020, 0x9072, 'CS', '1'],
        'FrameContentSequence' => [0x0020, 0x9111, 'SQ', '1'],
        'PlanePositionSequence' => [0x0020, 0x9113, 'SQ', '1'],
        'PlaneOrientationSequence' => [0x0020, 0x9116, 'SQ', '1'],
        'TemporalPositionIndex' => [0x0020, 0x9128, 'UL', '1'],
        'NominalCardiacTriggerDelayTime' => [0x0020, 0x9153, 'FD', '1'],
        'NominalCardiacTriggerTimePriorToRPeak' => [0x0020, 0x9154, 'FL', '1'],
        'ActualCardiacTriggerTimePriorToRPeak' => [0x0020, 0x9155, 'FL', '1'],
        'FrameAcquisitionNumber' => [0x0020, 0x9156, 'US', '1'],
        'DimensionIndexValues' => [0x0020, 0x9157, 'UL', '1-n'],
        'FrameComments' => [0x0020, 0x9158, 'LT', '1'],
        'ConcatenationUID' => [0x0020, 0x9161, 'UI', '1'],
        'InConcatenationNumber' => [0x0020, 0x9162, 'US', '1'],
        'InConcatenationTotalNumber' => [0x0020, 0x9163, 'US', '1'],
        'DimensionOrganizationUID' => [0x0020, 0x9164, 'UI', '1'],
        'DimensionIndexPointer' => [0x0020, 0x9165, 'AT', '1'],
        'FunctionalGroupPointer' => [0x0020, 0x9167, 'AT', '1'],
        'UnassignedSharedConvertedAttributesSequence' => [0x0020, 0x9170, 'SQ', '1'],
        'UnassignedPerFrameConvertedAttributesSequence' => [0x0020, 0x9171, 'SQ', '1'],
        'ConversionSourceAttributesSequence' => [0x0020, 0x9172, 'SQ', '1'],
        'DimensionIndexPrivateCreator' => [0x0020, 0x9213, 'LO', '1'],
        'DimensionOrganizationSequence' => [0x0020, 0x9221, 'SQ', '1'],
        'DimensionIndexSequence' => [0x0020, 0x9222, 'SQ', '1'],
        'ConcatenationFrameOffsetNumber' => [0x0020, 0x9228, 'UL', '1'],
        'FunctionalGroupPrivateCreator' => [0x0020, 0x9238, 'LO', '1'],
        'NominalPercentageOfCardiacPhase' => [0x0020, 0x9241, 'FL', '1'],
        'NominalPercentageOfRespiratoryPhase' => [0x0020, 0x9245, 'FL', '1'],
        'StartingRespiratoryAmplitude' => [0x0020, 0x9246, 'FL', '1'],
        'StartingRespiratoryPhase' => [0x0020, 0x9247, 'CS', '1'],
        'EndingRespiratoryAmplitude' => [0x0020, 0x9248, 'FL', '1'],
        'EndingRespiratoryPhase' => [0x0020, 0x9249, 'CS', '1'],
        'RespiratoryTriggerType' => [0x0020, 0x9250, 'CS', '1'],
        'RRIntervalTimeNominal' => [0x0020, 0x9251, 'FD', '1'],
        'ActualCardiacTriggerDelayTime' => [0x0020, 0x9252, 'FD', '1'],
        'RespiratorySynchronizationSequence' => [0x0020, 0x9253, 'SQ', '1'],
        'RespiratoryIntervalTime' => [0x0020, 0x9254, 'FD', '1'],
        'NominalRespiratoryTriggerDelayTime' => [0x0020, 0x9255, 'FD', '1'],
        'RespiratoryTriggerDelayThreshold' => [0x0020, 0x9256, 'FD', '1'],
        'ActualRespiratoryTriggerDelayTime' => [0x0020, 0x9257, 'FD', '1'],
        'ImagePositionVolume' => [0x0020, 0x9301, 'FD', '3'],
        'ImageOrientationVolume' => [0x0020, 0x9302, 'FD', '6'],
        'UltrasoundAcquisitionGeometry' => [0x0020, 0x9307, 'CS', '1'],
        'ApexPosition' => [0x0020, 0x9308, 'FD', '3'],
        'VolumeToTransducerMappingMatrix' => [0x0020, 0x9309, 'FD', '16'],
        'VolumeToTableMappingMatrix' => [0x0020, 0x930a, 'FD', '16'],
        'VolumeToTransducerRelationship' => [0x0020, 0x930b, 'CS', '1'],
        'PatientFrameOfReferenceSource' => [0x0020, 0x930c, 'CS', '1'],
        'TemporalPositionTimeOffset' => [0x0020, 0x930d, 'FD', '1'],
        'PlanePositionVolumeSequence' => [0x0020, 0x930e, 'SQ', '1'],
        'PlaneOrientationVolumeSequence' => [0x0020, 0x930f, 'SQ', '1'],
        'TemporalPositionSequence' => [0x0020, 0x9310, 'SQ', '1'],
        'DimensionOrganizationType' => [0x0020, 0x9311, 'CS', '1'],
        'VolumeFrameOfReferenceUID' => [0x0020, 0x9312, 'UI', '1'],
        'TableFrameOfReferenceUID' => [0x0020, 0x9313, 'UI', '1'],
        'DimensionDescriptionLabel' => [0x0020, 0x9421, 'LO', '1'],
        'PatientOrientationInFrameSequence' => [0x0020, 0x9450, 'SQ', '1'],
        'FrameLabel' => [0x0020, 0x9453, 'LO', '1'],
        'AcquisitionIndex' => [0x0020, 0x9518, 'US', '1-n'],
        'ContributingSOPInstancesReferenceSequence' => [0x0020, 0x9529, 'SQ', '1'],
        'ReconstructionIndex' => [0x0020, 0x9536, 'US', '1'],
        'LightPathFilterPassThroughWavelength' => [0x0022, 0x0001, 'US', '1'],
        'LightPathFilterPassBand' => [0x0022, 0x0002, 'US', '2'],
        'ImagePathFilterPassThroughWavelength' => [0x0022, 0x0003, 'US', '1'],
        'ImagePathFilterPassBand' => [0x0022, 0x0004, 'US', '2'],
        'PatientEyeMovementCommanded' => [0x0022, 0x0005, 'CS', '1'],
        'PatientEyeMovementCommandCodeSequence' => [0x0022, 0x0006, 'SQ', '1'],
        'SphericalLensPower' => [0x0022, 0x0007, 'FL', '1'],
        'CylinderLensPower' => [0x0022, 0x0008, 'FL', '1'],
        'CylinderAxis' => [0x0022, 0x0009, 'FL', '1'],
        'EmmetropicMagnification' => [0x0022, 0x000a, 'FL', '1'],
        'IntraOcularPressure' => [0x0022, 0x000b, 'FL', '1'],
        'HorizontalFieldOfView' => [0x0022, 0x000c, 'FL', '1'],
        'PupilDilated' => [0x0022, 0x000d, 'CS', '1'],
        'DegreeOfDilation' => [0x0022, 0x000e, 'FL', '1'],
        'VertexDistance' => [0x0022, 0x000f, 'FD', '1'],
        'StereoBaselineAngle' => [0x0022, 0x0010, 'FL', '1'],
        'StereoBaselineDisplacement' => [0x0022, 0x0011, 'FL', '1'],
        'StereoHorizontalPixelOffset' => [0x0022, 0x0012, 'FL', '1'],
        'StereoVerticalPixelOffset' => [0x0022, 0x0013, 'FL', '1'],
        'StereoRotation' => [0x0022, 0x0014, 'FL', '1'],
        'AcquisitionDeviceTypeCodeSequence' => [0x0022, 0x0015, 'SQ', '1'],
        'IlluminationTypeCodeSequence' => [0x0022, 0x0016, 'SQ', '1'],
        'LightPathFilterTypeStackCodeSequence' => [0x0022, 0x0017, 'SQ', '1'],
        'ImagePathFilterTypeStackCodeSequence' => [0x0022, 0x0018, 'SQ', '1'],
        'LensesCodeSequence' => [0x0022, 0x0019, 'SQ', '1'],
        'ChannelDescriptionCodeSequence' => [0x0022, 0x001a, 'SQ', '1'],
        'RefractiveStateSequence' => [0x0022, 0x001b, 'SQ', '1'],
        'MydriaticAgentCodeSequence' => [0x0022, 0x001c, 'SQ', '1'],
        'RelativeImagePositionCodeSequence' => [0x0022, 0x001d, 'SQ', '1'],
        'CameraAngleOfView' => [0x0022, 0x001e, 'FL', '1'],
        'StereoPairsSequence' => [0x0022, 0x0020, 'SQ', '1'],
        'LeftImageSequence' => [0x0022, 0x0021, 'SQ', '1'],
        'RightImageSequence' => [0x0022, 0x0022, 'SQ', '1'],
        'StereoPairsPresent' => [0x0022, 0x0028, 'CS', '1'],
        'AxialLengthOfTheEye' => [0x0022, 0x0030, 'FL', '1'],
        'OphthalmicFrameLocationSequence' => [0x0022, 0x0031, 'SQ', '1'],
        'ReferenceCoordinates' => [0x0022, 0x0032, 'FL', '2-2n'],
        'DepthSpatialResolution' => [0x0022, 0x0035, 'FL', '1'],
        'MaximumDepthDistortion' => [0x0022, 0x0036, 'FL', '1'],
        'AlongScanSpatialResolution' => [0x0022, 0x0037, 'FL', '1'],
        'MaximumAlongScanDistortion' => [0x0022, 0x0038, 'FL', '1'],
        'OphthalmicImageOrientation' => [0x0022, 0x0039, 'CS', '1'],
        'DepthOfTransverseImage' => [0x0022, 0x0041, 'FL', '1'],
        'MydriaticAgentConcentrationUnitsSequence' => [0x0022, 0x0042, 'SQ', '1'],
        'AcrossScanSpatialResolution' => [0x0022, 0x0048, 'FL', '1'],
        'MaximumAcrossScanDistortion' => [0x0022, 0x0049, 'FL', '1'],
        'MydriaticAgentConcentration' => [0x0022, 0x004e, 'DS', '1'],
        'IlluminationWaveLength' => [0x0022, 0x0055, 'FL', '1'],
        'IlluminationPower' => [0x0022, 0x0056, 'FL', '1'],
        'IlluminationBandwidth' => [0x0022, 0x0057, 'FL', '1'],
        'MydriaticAgentSequence' => [0x0022, 0x0058, 'SQ', '1'],
        'OphthalmicAxialMeasurementsRightEyeSequence' => [0x0022, 0x1007, 'SQ', '1'],
        'OphthalmicAxialMeasurementsLeftEyeSequence' => [0x0022, 0x1008, 'SQ', '1'],
        'OphthalmicAxialMeasurementsDeviceType' => [0x0022, 0x1009, 'CS', '1'],
        'OphthalmicAxialLengthMeasurementsType' => [0x0022, 0x1010, 'CS', '1'],
        'OphthalmicAxialLengthSequence' => [0x0022, 0x1012, 'SQ', '1'],
        'OphthalmicAxialLength' => [0x0022, 0x1019, 'FL', '1'],
        'LensStatusCodeSequence' => [0x0022, 0x1024, 'SQ', '1'],
        'VitreousStatusCodeSequence' => [0x0022, 0x1025, 'SQ', '1'],
        'IOLFormulaCodeSequence' => [0x0022, 0x1028, 'SQ', '1'],
        'IOLFormulaDetail' => [0x0022, 0x1029, 'LO', '1'],
        'KeratometerIndex' => [0x0022, 0x1033, 'FL', '1'],
        'SourceOfOphthalmicAxialLengthCodeSequence' => [0x0022, 0x1035, 'SQ', '1'],
        'SourceOfCornealSizeDataCodeSequence' => [0x0022, 0x1036, 'SQ', '1'],
        'TargetRefraction' => [0x0022, 0x1037, 'FL', '1'],
        'RefractiveProcedureOccurred' => [0x0022, 0x1039, 'CS', '1'],
        'RefractiveSurgeryTypeCodeSequence' => [0x0022, 0x1040, 'SQ', '1'],
        'OphthalmicUltrasoundMethodCodeSequence' => [0x0022, 0x1044, 'SQ', '1'],
        'SurgicallyInducedAstigmatismSequence' => [0x0022, 0x1045, 'SQ', '1'],
        'TypeOfOpticalCorrection' => [0x0022, 0x1046, 'CS', '1'],
        'ToricIOLPowerSequence' => [0x0022, 0x1047, 'SQ', '1'],
        'PredictedToricErrorSequence' => [0x0022, 0x1048, 'SQ', '1'],
        'PreSelectedForImplantation' => [0x0022, 0x1049, 'CS', '1'],
        'ToricIOLPowerForExactEmmetropiaSequence' => [0x0022, 0x104a, 'SQ', '1'],
        'ToricIOLPowerForExactTargetRefractionSequence' => [0x0022, 0x104b, 'SQ', '1'],
        'OphthalmicAxialLengthMeasurementsSequence' => [0x0022, 0x1050, 'SQ', '1'],
        'IOLPower' => [0x0022, 0x1053, 'FL', '1'],
        'PredictedRefractiveError' => [0x0022, 0x1054, 'FL', '1'],
        'OphthalmicAxialLengthVelocity' => [0x0022, 0x1059, 'FL', '1'],
        'LensStatusDescription' => [0x0022, 0x1065, 'LO', '1'],
        'VitreousStatusDescription' => [0x0022, 0x1066, 'LO', '1'],
        'IOLPowerSequence' => [0x0022, 0x1090, 'SQ', '1'],
        'LensConstantSequence' => [0x0022, 0x1092, 'SQ', '1'],
        'IOLManufacturer' => [0x0022, 0x1093, 'LO', '1'],
        'ImplantName' => [0x0022, 0x1095, 'LO', '1'],
        'KeratometryMeasurementTypeCodeSequence' => [0x0022, 0x1096, 'SQ', '1'],
        'ImplantPartNumber' => [0x0022, 0x1097, 'LO', '1'],
        'ReferencedOphthalmicAxialMeasurementsSequence' => [0x0022, 0x1100, 'SQ', '1'],
        'OphthalmicAxialLengthMeasurementsSegmentNameCodeSequence' => [0x0022, 0x1101, 'SQ', '1'],
        'RefractiveErrorBeforeRefractiveSurgeryCodeSequence' => [0x0022, 0x1103, 'SQ', '1'],
        'IOLPowerForExactEmmetropia' => [0x0022, 0x1121, 'FL', '1'],
        'IOLPowerForExactTargetRefraction' => [0x0022, 0x1122, 'FL', '1'],
        'AnteriorChamberDepthDefinitionCodeSequence' => [0x0022, 0x1125, 'SQ', '1'],
        'LensThicknessSequence' => [0x0022, 0x1127, 'SQ', '1'],
        'AnteriorChamberDepthSequence' => [0x0022, 0x1128, 'SQ', '1'],
        'CalculationCommentSequence' => [0x0022, 0x112a, 'SQ', '1'],
        'CalculationCommentType' => [0x0022, 0x112b, 'CS', '1'],
        'CalculationComment' => [0x0022, 0x112c, 'LT', '1'],
        'LensThickness' => [0x0022, 0x1130, 'FL', '1'],
        'AnteriorChamberDepth' => [0x0022, 0x1131, 'FL', '1'],
        'SourceOfLensThicknessDataCodeSequence' => [0x0022, 0x1132, 'SQ', '1'],
        'SourceOfAnteriorChamberDepthDataCodeSequence' => [0x0022, 0x1133, 'SQ', '1'],
        'SourceOfRefractiveMeasurementsSequence' => [0x0022, 0x1134, 'SQ', '1'],
        'SourceOfRefractiveMeasurementsCodeSequence' => [0x0022, 0x1135, 'SQ', '1'],
        'OphthalmicAxialLengthMeasurementModified' => [0x0022, 0x1140, 'CS', '1'],
        'OphthalmicAxialLengthDataSourceCodeSequence' => [0x0022, 0x1150, 'SQ', '1'],
        'SignalToNoiseRatio' => [0x0022, 0x1155, 'FL', '1'],
        'OphthalmicAxialLengthDataSourceDescription' => [0x0022, 0x1159, 'LO', '1'],
        'OphthalmicAxialLengthMeasurementsTotalLengthSequence' => [0x0022, 0x1210, 'SQ', '1'],
        'OphthalmicAxialLengthMeasurementsSegmentalLengthSequence' => [0x0022, 0x1211, 'SQ', '1'],
        'OphthalmicAxialLengthMeasurementsLengthSummationSequence' => [0x0022, 0x1212, 'SQ', '1'],
        'UltrasoundOphthalmicAxialLengthMeasurementsSequence' => [0x0022, 0x1220, 'SQ', '1'],
        'OpticalOphthalmicAxialLengthMeasurementsSequence' => [0x0022, 0x1225, 'SQ', '1'],
        'UltrasoundSelectedOphthalmicAxialLengthSequence' => [0x0022, 0x1230, 'SQ', '1'],
        'OphthalmicAxialLengthSelectionMethodCodeSequence' => [0x0022, 0x1250, 'SQ', '1'],
        'OpticalSelectedOphthalmicAxialLengthSequence' => [0x0022, 0x1255, 'SQ', '1'],
        'SelectedSegmentalOphthalmicAxialLengthSequence' => [0x0022, 0x1257, 'SQ', '1'],
        'SelectedTotalOphthalmicAxialLengthSequence' => [0x0022, 0x1260, 'SQ', '1'],
        'OphthalmicAxialLengthQualityMetricSequence' => [0x0022, 0x1262, 'SQ', '1'],
        'IntraocularLensCalculationsRightEyeSequence' => [0x0022, 0x1300, 'SQ', '1'],
        'IntraocularLensCalculationsLeftEyeSequence' => [0x0022, 0x1310, 'SQ', '1'],
        'ReferencedOphthalmicAxialLengthMeasurementQCImageSequence' => [0x0022, 0x1330, 'SQ', '1'],
        'OphthalmicMappingDeviceType' => [0x0022, 0x1415, 'CS', '1'],
        'AcquisitionMethodCodeSequence' => [0x0022, 0x1420, 'SQ', '1'],
        'AcquisitionMethodAlgorithmSequence' => [0x0022, 0x1423, 'SQ', '1'],
        'OphthalmicThicknessMapTypeCodeSequence' => [0x0022, 0x1436, 'SQ', '1'],
        'OphthalmicThicknessMappingNormalsSequence' => [0x0022, 0x1443, 'SQ', '1'],
        'RetinalThicknessDefinitionCodeSequence' => [0x0022, 0x1445, 'SQ', '1'],
        'PixelValueMappingToCodedConceptSequence' => [0x0022, 0x1450, 'SQ', '1'],
        'MappedPixelValue' => [0x0022, 0x1452, 'xs', '1'],
        'PixelValueMappingExplanation' => [0x0022, 0x1454, 'LO', '1'],
        'OphthalmicThicknessMapQualityThresholdSequence' => [0x0022, 0x1458, 'SQ', '1'],
        'OphthalmicThicknessMapThresholdQualityRating' => [0x0022, 0x1460, 'FL', '1'],
        'AnatomicStructureReferencePoint' => [0x0022, 0x1463, 'FL', '2'],
        'RegistrationToLocalizerSequence' => [0x0022, 0x1465, 'SQ', '1'],
        'RegisteredLocalizerUnits' => [0x0022, 0x1466, 'CS', '1'],
        'RegisteredLocalizerTopLeftHandCorner' => [0x0022, 0x1467, 'FL', '2'],
        'RegisteredLocalizerBottomRightHandCorner' => [0x0022, 0x1468, 'FL', '2'],
        'OphthalmicThicknessMapQualityRatingSequence' => [0x0022, 0x1470, 'SQ', '1'],
        'RelevantOPTAttributesSequence' => [0x0022, 0x1472, 'SQ', '1'],
        'TransformationMethodCodeSequence' => [0x0022, 0x1512, 'SQ', '1'],
        'TransformationAlgorithmSequence' => [0x0022, 0x1513, 'SQ', '1'],
        'OphthalmicAxialLengthMethod' => [0x0022, 0x1515, 'CS', '1'],
        'OphthalmicFOV' => [0x0022, 0x1517, 'FL', '1'],
        'TwoDimensionalToThreeDimensionalMapSequence' => [0x0022, 0x1518, 'SQ', '1'],
        'WideFieldOphthalmicPhotographyQualityRatingSequence' => [0x0022, 0x1525, 'SQ', '1'],
        'WideFieldOphthalmicPhotographyQualityThresholdSequence' => [0x0022, 0x1526, 'SQ', '1'],
        'WideFieldOphthalmicPhotographyThresholdQualityRating' => [0x0022, 0x1527, 'FL', '1'],
        'XCoordinatesCenterPixelViewAngle' => [0x0022, 0x1528, 'FL', '1'],
        'YCoordinatesCenterPixelViewAngle' => [0x0022, 0x1529, 'FL', '1'],
        'NumberOfMapPoints' => [0x0022, 0x1530, 'UL', '1'],
        'TwoDimensionalToThreeDimensionalMapData' => [0x0022, 0x1531, 'OF', '1'],
        'DerivationAlgorithmSequence' => [0x0022, 0x1612, 'SQ', '1'],
        'OphthalmicImageTypeCodeSequence' => [0x0022, 0x1615, 'SQ', '1'],
        'OphthalmicImageTypeDescription' => [0x0022, 0x1616, 'LO', '1'],
        'ScanPatternTypeCodeSequence' => [0x0022, 0x1618, 'SQ', '1'],
        'ReferencedSurfaceMeshIdentificationSequence' => [0x0022, 0x1620, 'SQ', '1'],
        'OphthalmicVolumetricPropertiesFlag' => [0x0022, 0x1622, 'CS', '1'],
        'OphthalmicAnatomicReferencePointFrameCoordinate' => [0x0022, 0x1623, 'FL', '1'],
        'OphthalmicAnatomicReferencePointXCoordinate' => [0x0022, 0x1624, 'FL', '1'],
        'OphthalmicAnatomicReferencePointYCoordinate' => [0x0022, 0x1626, 'FL', '1'],
        'OphthalmicEnFaceVolumeDescriptorSequence' => [0x0022, 0x1627, 'SQ', '1'],
        'OphthalmicEnFaceImageQualityRatingSequence' => [0x0022, 0x1628, 'SQ', '1'],
        'OphthalmicEnFaceVolumeDescriptorScope' => [0x0022, 0x1629, 'CS', '1'],
        'QualityThreshold' => [0x0022, 0x1630, 'DS', '1'],
        'OphthalmicAnatomicReferencePointSequence' => [0x0022, 0x1632, 'SQ', '1'],
        'OphthalmicAnatomicReferencePointLocalizationType' => [0x0022, 0x1633, 'CS', '1'],
        'PrimaryAnatomicStructureItemIndex' => [0x0022, 0x1634, 'IS', '1'],
        'OCTBscanAnalysisAcquisitionParametersSequence' => [0x0022, 0x1640, 'SQ', '1'],
        'NumberOfBscansPerFrame' => [0x0022, 0x1642, 'UL', '1'],
        'BscanSlabThickness' => [0x0022, 0x1643, 'FL', '1'],
        'DistanceBetweenBscanSlabs' => [0x0022, 0x1644, 'FL', '1'],
        'BscanCycleTime' => [0x0022, 0x1645, 'FL', '1'],
        'BscanCycleTimeVector' => [0x0022, 0x1646, 'FL', '1-n'],
        'AscanRate' => [0x0022, 0x1649, 'FL', '1'],
        'BscanRate' => [0x0022, 0x1650, 'FL', '1'],
        'SurfaceMeshZPixelOffset' => [0x0022, 0x1658, 'UL', '1'],
        'VisualFieldHorizontalExtent' => [0x0024, 0x0010, 'FL', '1'],
        'VisualFieldVerticalExtent' => [0x0024, 0x0011, 'FL', '1'],
        'VisualFieldShape' => [0x0024, 0x0012, 'CS', '1'],
        'ScreeningTestModeCodeSequence' => [0x0024, 0x0016, 'SQ', '1'],
        'MaximumStimulusLuminance' => [0x0024, 0x0018, 'FL', '1'],
        'BackgroundLuminance' => [0x0024, 0x0020, 'FL', '1'],
        'StimulusColorCodeSequence' => [0x0024, 0x0021, 'SQ', '1'],
        'BackgroundIlluminationColorCodeSequence' => [0x0024, 0x0024, 'SQ', '1'],
        'StimulusArea' => [0x0024, 0x0025, 'FL', '1'],
        'StimulusPresentationTime' => [0x0024, 0x0028, 'FL', '1'],
        'FixationSequence' => [0x0024, 0x0032, 'SQ', '1'],
        'FixationMonitoringCodeSequence' => [0x0024, 0x0033, 'SQ', '1'],
        'VisualFieldCatchTrialSequence' => [0x0024, 0x0034, 'SQ', '1'],
        'FixationCheckedQuantity' => [0x0024, 0x0035, 'US', '1'],
        'PatientNotProperlyFixatedQuantity' => [0x0024, 0x0036, 'US', '1'],
        'PresentedVisualStimuliDataFlag' => [0x0024, 0x0037, 'CS', '1'],
        'NumberOfVisualStimuli' => [0x0024, 0x0038, 'US', '1'],
        'ExcessiveFixationLossesDataFlag' => [0x0024, 0x0039, 'CS', '1'],
        'ExcessiveFixationLosses' => [0x0024, 0x0040, 'CS', '1'],
        'StimuliRetestingQuantity' => [0x0024, 0x0042, 'US', '1'],
        'CommentsOnPatientPerformanceOfVisualField' => [0x0024, 0x0044, 'LT', '1'],
        'FalseNegativesEstimateFlag' => [0x0024, 0x0045, 'CS', '1'],
        'FalseNegativesEstimate' => [0x0024, 0x0046, 'FL', '1'],
        'NegativeCatchTrialsQuantity' => [0x0024, 0x0048, 'US', '1'],
        'FalseNegativesQuantity' => [0x0024, 0x0050, 'US', '1'],
        'ExcessiveFalseNegativesDataFlag' => [0x0024, 0x0051, 'CS', '1'],
        'ExcessiveFalseNegatives' => [0x0024, 0x0052, 'CS', '1'],
        'FalsePositivesEstimateFlag' => [0x0024, 0x0053, 'CS', '1'],
        'FalsePositivesEstimate' => [0x0024, 0x0054, 'FL', '1'],
        'CatchTrialsDataFlag' => [0x0024, 0x0055, 'CS', '1'],
        'PositiveCatchTrialsQuantity' => [0x0024, 0x0056, 'US', '1'],
        'TestPointNormalsDataFlag' => [0x0024, 0x0057, 'CS', '1'],
        'TestPointNormalsSequence' => [0x0024, 0x0058, 'SQ', '1'],
        'GlobalDeviationProbabilityNormalsFlag' => [0x0024, 0x0059, 'CS', '1'],
        'FalsePositivesQuantity' => [0x0024, 0x0060, 'US', '1'],
        'ExcessiveFalsePositivesDataFlag' => [0x0024, 0x0061, 'CS', '1'],
        'ExcessiveFalsePositives' => [0x0024, 0x0062, 'CS', '1'],
        'VisualFieldTestNormalsFlag' => [0x0024, 0x0063, 'CS', '1'],
        'ResultsNormalsSequence' => [0x0024, 0x0064, 'SQ', '1'],
        'AgeCorrectedSensitivityDeviationAlgorithmSequence' => [0x0024, 0x0065, 'SQ', '1'],
        'GlobalDeviationFromNormal' => [0x0024, 0x0066, 'FL', '1'],
        'GeneralizedDefectSensitivityDeviationAlgorithmSequence' => [0x0024, 0x0067, 'SQ', '1'],
        'LocalizedDeviationFromNormal' => [0x0024, 0x0068, 'FL', '1'],
        'PatientReliabilityIndicator' => [0x0024, 0x0069, 'LO', '1'],
        'VisualFieldMeanSensitivity' => [0x0024, 0x0070, 'FL', '1'],
        'GlobalDeviationProbability' => [0x0024, 0x0071, 'FL', '1'],
        'LocalDeviationProbabilityNormalsFlag' => [0x0024, 0x0072, 'CS', '1'],
        'LocalizedDeviationProbability' => [0x0024, 0x0073, 'FL', '1'],
        'ShortTermFluctuationCalculated' => [0x0024, 0x0074, 'CS', '1'],
        'ShortTermFluctuation' => [0x0024, 0x0075, 'FL', '1'],
        'ShortTermFluctuationProbabilityCalculated' => [0x0024, 0x0076, 'CS', '1'],
        'ShortTermFluctuationProbability' => [0x0024, 0x0077, 'FL', '1'],
        'CorrectedLocalizedDeviationFromNormalCalculated' => [0x0024, 0x0078, 'CS', '1'],
        'CorrectedLocalizedDeviationFromNormal' => [0x0024, 0x0079, 'FL', '1'],
        'CorrectedLocalizedDeviationFromNormalProbabilityCalculated' => [0x0024, 0x0080, 'CS', '1'],
        'CorrectedLocalizedDeviationFromNormalProbability' => [0x0024, 0x0081, 'FL', '1'],
        'GlobalDeviationProbabilitySequence' => [0x0024, 0x0083, 'SQ', '1'],
        'LocalizedDeviationProbabilitySequence' => [0x0024, 0x0085, 'SQ', '1'],
        'FovealSensitivityMeasured' => [0x0024, 0x0086, 'CS', '1'],
        'FovealSensitivity' => [0x0024, 0x0087, 'FL', '1'],
        'VisualFieldTestDuration' => [0x0024, 0x0088, 'FL', '1'],
        'VisualFieldTestPointSequence' => [0x0024, 0x0089, 'SQ', '1'],
        'VisualFieldTestPointXCoordinate' => [0x0024, 0x0090, 'FL', '1'],
        'VisualFieldTestPointYCoordinate' => [0x0024, 0x0091, 'FL', '1'],
        'AgeCorrectedSensitivityDeviationValue' => [0x0024, 0x0092, 'FL', '1'],
        'StimulusResults' => [0x0024, 0x0093, 'CS', '1'],
        'SensitivityValue' => [0x0024, 0x0094, 'FL', '1'],
        'RetestStimulusSeen' => [0x0024, 0x0095, 'CS', '1'],
        'RetestSensitivityValue' => [0x0024, 0x0096, 'FL', '1'],
        'VisualFieldTestPointNormalsSequence' => [0x0024, 0x0097, 'SQ', '1'],
        'QuantifiedDefect' => [0x0024, 0x0098, 'FL', '1'],
        'AgeCorrectedSensitivityDeviationProbabilityValue' => [0x0024, 0x0100, 'FL', '1'],
        'GeneralizedDefectCorrectedSensitivityDeviationFlag' => [0x0024, 0x0102, 'CS', '1'],
        'GeneralizedDefectCorrectedSensitivityDeviationValue' => [0x0024, 0x0103, 'FL', '1'],
        'GeneralizedDefectCorrectedSensitivityDeviationProbabilityValue' => [0x0024, 0x0104, 'FL', '1'],
        'MinimumSensitivityValue' => [0x0024, 0x0105, 'FL', '1'],
        'BlindSpotLocalized' => [0x0024, 0x0106, 'CS', '1'],
        'BlindSpotXCoordinate' => [0x0024, 0x0107, 'FL', '1'],
        'BlindSpotYCoordinate' => [0x0024, 0x0108, 'FL', '1'],
        'VisualAcuityMeasurementSequence' => [0x0024, 0x0110, 'SQ', '1'],
        'RefractiveParametersUsedOnPatientSequence' => [0x0024, 0x0112, 'SQ', '1'],
        'MeasurementLaterality' => [0x0024, 0x0113, 'CS', '1'],
        'OphthalmicPatientClinicalInformationLeftEyeSequence' => [0x0024, 0x0114, 'SQ', '1'],
        'OphthalmicPatientClinicalInformationRightEyeSequence' => [0x0024, 0x0115, 'SQ', '1'],
        'FovealPointNormativeDataFlag' => [0x0024, 0x0117, 'CS', '1'],
        'FovealPointProbabilityValue' => [0x0024, 0x0118, 'FL', '1'],
        'ScreeningBaselineMeasured' => [0x0024, 0x0120, 'CS', '1'],
        'ScreeningBaselineMeasuredSequence' => [0x0024, 0x0122, 'SQ', '1'],
        'ScreeningBaselineType' => [0x0024, 0x0124, 'CS', '1'],
        'ScreeningBaselineValue' => [0x0024, 0x0126, 'FL', '1'],
        'AlgorithmSource' => [0x0024, 0x0202, 'LO', '1'],
        'DataSetName' => [0x0024, 0x0306, 'LO', '1'],
        'DataSetVersion' => [0x0024, 0x0307, 'LO', '1'],
        'DataSetSource' => [0x0024, 0x0308, 'LO', '1'],
        'DataSetDescription' => [0x0024, 0x0309, 'LO', '1'],
        'VisualFieldTestReliabilityGlobalIndexSequence' => [0x0024, 0x0317, 'SQ', '1'],
        'VisualFieldGlobalResultsIndexSequence' => [0x0024, 0x0320, 'SQ', '1'],
        'DataObservationSequence' => [0x0024, 0x0325, 'SQ', '1'],
        'IndexNormalsFlag' => [0x0024, 0x0338, 'CS', '1'],
        'IndexProbability' => [0x0024, 0x0341, 'FL', '1'],
        'IndexProbabilitySequence' => [0x0024, 0x0344, 'SQ', '1'],
        'SamplesPerPixel' => [0x0028, 0x0002, 'US', '1'],
        'SamplesPerPixelUsed' => [0x0028, 0x0003, 'US', '1'],
        'PhotometricInterpretation' => [0x0028, 0x0004, 'CS', '1'],
        'PlanarConfiguration' => [0x0028, 0x0006, 'US', '1'],
        'NumberOfFrames' => [0x0028, 0x0008, 'IS', '1'],
        'FrameIncrementPointer' => [0x0028, 0x0009, 'AT', '1-n'],
        'FrameDimensionPointer' => [0x0028, 0x000a, 'AT', '1-n'],
        'Rows' => [0x0028, 0x0010, 'US', '1'],
        'Columns' => [0x0028, 0x0011, 'US', '1'],
        'UltrasoundColorDataPresent' => [0x0028, 0x0014, 'US', '1'],
        'PixelSpacing' => [0x0028, 0x0030, 'DS', '2'],
        'ZoomFactor' => [0x0028, 0x0031, 'DS', '2'],
        'ZoomCenter' => [0x0028, 0x0032, 'DS', '2'],
        'PixelAspectRatio' => [0x0028, 0x0034, 'IS', '2'],
        'CorrectedImage' => [0x0028, 0x0051, 'CS', '1-n'],
        'BitsAllocated' => [0x0028, 0x0100, 'US', '1'],
        'BitsStored' => [0x0028, 0x0101, 'US', '1'],
        'HighBit' => [0x0028, 0x0102, 'US', '1'],
        'PixelRepresentation' => [0x0028, 0x0103, 'US', '1'],
        'SmallestImagePixelValue' => [0x0028, 0x0106, 'xs', '1'],
        'LargestImagePixelValue' => [0x0028, 0x0107, 'xs', '1'],
        'SmallestPixelValueInSeries' => [0x0028, 0x0108, 'xs', '1'],
        'LargestPixelValueInSeries' => [0x0028, 0x0109, 'xs', '1'],
        'PixelPaddingValue' => [0x0028, 0x0120, 'xs', '1'],
        'PixelPaddingRangeLimit' => [0x0028, 0x0121, 'xs', '1'],
        'FloatPixelPaddingValue' => [0x0028, 0x0122, 'FL', '1'],
        'DoubleFloatPixelPaddingValue' => [0x0028, 0x0123, 'FD', '1'],
        'FloatPixelPaddingRangeLimit' => [0x0028, 0x0124, 'FL', '1'],
        'DoubleFloatPixelPaddingRangeLimit' => [0x0028, 0x0125, 'FD', '1'],
        'QualityControlImage' => [0x0028, 0x0300, 'CS', '1'],
        'BurnedInAnnotation' => [0x0028, 0x0301, 'CS', '1'],
        'RecognizableVisualFeatures' => [0x0028, 0x0302, 'CS', '1'],
        'LongitudinalTemporalInformationModified' => [0x0028, 0x0303, 'CS', '1'],
        'ReferencedColorPaletteInstanceUID' => [0x0028, 0x0304, 'UI', '1'],
        'PixelSpacingCalibrationType' => [0x0028, 0x0a02, 'CS', '1'],
        'PixelSpacingCalibrationDescription' => [0x0028, 0x0a04, 'LO', '1'],
        'PixelIntensityRelationship' => [0x0028, 0x1040, 'CS', '1'],
        'PixelIntensityRelationshipSign' => [0x0028, 0x1041, 'SS', '1'],
        'WindowCenter' => [0x0028, 0x1050, 'DS', '1-n'],
        'WindowWidth' => [0x0028, 0x1051, 'DS', '1-n'],
        'RescaleIntercept' => [0x0028, 0x1052, 'DS', '1'],
        'RescaleSlope' => [0x0028, 0x1053, 'DS', '1'],
        'RescaleType' => [0x0028, 0x1054, 'LO', '1'],
        'WindowCenterWidthExplanation' => [0x0028, 0x1055, 'LO', '1-n'],
        'VOILUTFunction' => [0x0028, 0x1056, 'CS', '1'],
        'RecommendedViewingMode' => [0x0028, 0x1090, 'CS', '1'],
        'RedPaletteColorLookupTableDescriptor' => [0x0028, 0x1101, 'xs', '3'],
        'GreenPaletteColorLookupTableDescriptor' => [0x0028, 0x1102, 'xs', '3'],
        'BluePaletteColorLookupTableDescriptor' => [0x0028, 0x1103, 'xs', '3'],
        'AlphaPaletteColorLookupTableDescriptor' => [0x0028, 0x1104, 'US', '3'],
        'PaletteColorLookupTableUID' => [0x0028, 0x1199, 'UI', '1'],
        'RedPaletteColorLookupTableData' => [0x0028, 0x1201, 'OW', '1'],
        'GreenPaletteColorLookupTableData' => [0x0028, 0x1202, 'OW', '1'],
        'BluePaletteColorLookupTableData' => [0x0028, 0x1203, 'OW', '1'],
        'AlphaPaletteColorLookupTableData' => [0x0028, 0x1204, 'OW', '1'],
        'SegmentedRedPaletteColorLookupTableData' => [0x0028, 0x1221, 'OW', '1'],
        'SegmentedGreenPaletteColorLookupTableData' => [0x0028, 0x1222, 'OW', '1'],
        'SegmentedBluePaletteColorLookupTableData' => [0x0028, 0x1223, 'OW', '1'],
        'SegmentedAlphaPaletteColorLookupTableData' => [0x0028, 0x1224, 'OW', '1'],
        'StoredValueColorRangeSequence' => [0x0028, 0x1230, 'SQ', '1'],
        'MinimumStoredValueMapped' => [0x0028, 0x1231, 'FD', '1'],
        'MaximumStoredValueMapped' => [0x0028, 0x1232, 'FD', '1'],
        'BreastImplantPresent' => [0x0028, 0x1300, 'CS', '1'],
        'PartialView' => [0x0028, 0x1350, 'CS', '1'],
        'PartialViewDescription' => [0x0028, 0x1351, 'ST', '1'],
        'PartialViewCodeSequence' => [0x0028, 0x1352, 'SQ', '1'],
        'SpatialLocationsPreserved' => [0x0028, 0x135a, 'CS', '1'],
        'DataFrameAssignmentSequence' => [0x0028, 0x1401, 'SQ', '1'],
        'DataPathAssignment' => [0x0028, 0x1402, 'CS', '1'],
        'BitsMappedToColorLookupTable' => [0x0028, 0x1403, 'US', '1'],
        'BlendingLUT1Sequence' => [0x0028, 0x1404, 'SQ', '1'],
        'BlendingLUT1TransferFunction' => [0x0028, 0x1405, 'CS', '1'],
        'BlendingWeightConstant' => [0x0028, 0x1406, 'FD', '1'],
        'BlendingLookupTableDescriptor' => [0x0028, 0x1407, 'US', '3'],
        'BlendingLookupTableData' => [0x0028, 0x1408, 'OW', '1'],
        'EnhancedPaletteColorLookupTableSequence' => [0x0028, 0x140b, 'SQ', '1'],
        'BlendingLUT2Sequence' => [0x0028, 0x140c, 'SQ', '1'],
        'BlendingLUT2TransferFunction' => [0x0028, 0x140d, 'CS', '1'],
        'DataPathID' => [0x0028, 0x140e, 'CS', '1'],
        'RGBLUTTransferFunction' => [0x0028, 0x140f, 'CS', '1'],
        'AlphaLUTTransferFunction' => [0x0028, 0x1410, 'CS', '1'],
        'ICCProfile' => [0x0028, 0x2000, 'OB', '1'],
        'ColorSpace' => [0x0028, 0x2002, 'CS', '1'],
        'LossyImageCompression' => [0x0028, 0x2110, 'CS', '1'],
        'LossyImageCompressionRatio' => [0x0028, 0x2112, 'DS', '1-n'],
        'LossyImageCompressionMethod' => [0x0028, 0x2114, 'CS', '1-n'],
        'ModalityLUTSequence' => [0x0028, 0x3000, 'SQ', '1'],
        'VariableModalityLUTSequence' => [0x0028, 0x3001, 'SQ', '1'],
        'LUTDescriptor' => [0x0028, 0x3002, 'xs', '3'],
        'LUTExplanation' => [0x0028, 0x3003, 'LO', '1'],
        'ModalityLUTType' => [0x0028, 0x3004, 'LO', '1'],
        'LUTData' => [0x0028, 0x3006, 'lt', '1-n'],
        'VOILUTSequence' => [0x0028, 0x3010, 'SQ', '1'],
        'SoftcopyVOILUTSequence' => [0x0028, 0x3110, 'SQ', '1'],
        'RepresentativeFrameNumber' => [0x0028, 0x6010, 'US', '1'],
        'FrameNumbersOfInterest' => [0x0028, 0x6020, 'US', '1-n'],
        'FrameOfInterestDescription' => [0x0028, 0x6022, 'LO', '1-n'],
        'FrameOfInterestType' => [0x0028, 0x6023, 'CS', '1-n'],
        'RWavePointer' => [0x0028, 0x6040, 'US', '1-n'],
        'MaskSubtractionSequence' => [0x0028, 0x6100, 'SQ', '1'],
        'MaskOperation' => [0x0028, 0x6101, 'CS', '1'],
        'ApplicableFrameRange' => [0x0028, 0x6102, 'US', '2-2n'],
        'MaskFrameNumbers' => [0x0028, 0x6110, 'US', '1-n'],
        'ContrastFrameAveraging' => [0x0028, 0x6112, 'US', '1'],
        'MaskSubPixelShift' => [0x0028, 0x6114, 'FL', '2'],
        'TIDOffset' => [0x0028, 0x6120, 'SS', '1'],
        'MaskOperationExplanation' => [0x0028, 0x6190, 'ST', '1'],
        'EquipmentAdministratorSequence' => [0x0028, 0x7000, 'SQ', '1'],
        'NumberOfDisplaySubsystems' => [0x0028, 0x7001, 'US', '1'],
        'CurrentConfigurationID' => [0x0028, 0x7002, 'US', '1'],
        'DisplaySubsystemID' => [0x0028, 0x7003, 'US', '1'],
        'DisplaySubsystemName' => [0x0028, 0x7004, 'SH', '1'],
        'DisplaySubsystemDescription' => [0x0028, 0x7005, 'LO', '1'],
        'SystemStatus' => [0x0028, 0x7006, 'CS', '1'],
        'SystemStatusComment' => [0x0028, 0x7007, 'LO', '1'],
        'TargetLuminanceCharacteristicsSequence' => [0x0028, 0x7008, 'SQ', '1'],
        'LuminanceCharacteristicsID' => [0x0028, 0x7009, 'US', '1'],
        'DisplaySubsystemConfigurationSequence' => [0x0028, 0x700a, 'SQ', '1'],
        'ConfigurationID' => [0x0028, 0x700b, 'US', '1'],
        'ConfigurationName' => [0x0028, 0x700c, 'SH', '1'],
        'ConfigurationDescription' => [0x0028, 0x700d, 'LO', '1'],
        'ReferencedTargetLuminanceCharacteristicsID' => [0x0028, 0x700e, 'US', '1'],
        'QAResultsSequence' => [0x0028, 0x700f, 'SQ', '1'],
        'DisplaySubsystemQAResultsSequence' => [0x0028, 0x7010, 'SQ', '1'],
        'ConfigurationQAResultsSequence' => [0x0028, 0x7011, 'SQ', '1'],
        'MeasurementEquipmentSequence' => [0x0028, 0x7012, 'SQ', '1'],
        'MeasurementFunctions' => [0x0028, 0x7013, 'CS', '1-n'],
        'MeasurementEquipmentType' => [0x0028, 0x7014, 'CS', '1'],
        'VisualEvaluationResultSequence' => [0x0028, 0x7015, 'SQ', '1'],
        'DisplayCalibrationResultSequence' => [0x0028, 0x7016, 'SQ', '1'],
        'DDLValue' => [0x0028, 0x7017, 'US', '1'],
        'CIExyWhitePoint' => [0x0028, 0x7018, 'FL', '2'],
        'DisplayFunctionType' => [0x0028, 0x7019, 'CS', '1'],
        'GammaValue' => [0x0028, 0x701a, 'FL', '1'],
        'NumberOfLuminancePoints' => [0x0028, 0x701b, 'US', '1'],
        'LuminanceResponseSequence' => [0x0028, 0x701c, 'SQ', '1'],
        'TargetMinimumLuminance' => [0x0028, 0x701d, 'FL', '1'],
        'TargetMaximumLuminance' => [0x0028, 0x701e, 'FL', '1'],
        'LuminanceValue' => [0x0028, 0x701f, 'FL', '1'],
        'LuminanceResponseDescription' => [0x0028, 0x7020, 'LO', '1'],
        'WhitePointFlag' => [0x0028, 0x7021, 'CS', '1'],
        'DisplayDeviceTypeCodeSequence' => [0x0028, 0x7022, 'SQ', '1'],
        'DisplaySubsystemSequence' => [0x0028, 0x7023, 'SQ', '1'],
        'LuminanceResultSequence' => [0x0028, 0x7024, 'SQ', '1'],
        'AmbientLightValueSource' => [0x0028, 0x7025, 'CS', '1'],
        'MeasuredCharacteristics' => [0x0028, 0x7026, 'CS', '1-n'],
        'LuminanceUniformityResultSequence' => [0x0028, 0x7027, 'SQ', '1'],
        'VisualEvaluationTestSequence' => [0x0028, 0x7028, 'SQ', '1'],
        'TestResult' => [0x0028, 0x7029, 'CS', '1'],
        'TestResultComment' => [0x0028, 0x702a, 'LO', '1'],
        'TestImageValidation' => [0x0028, 0x702b, 'CS', '1'],
        'TestPatternCodeSequence' => [0x0028, 0x702c, 'SQ', '1'],
        'MeasurementPatternCodeSequence' => [0x0028, 0x702d, 'SQ', '1'],
        'VisualEvaluationMethodCodeSequence' => [0x0028, 0x702e, 'SQ', '1'],
        'PixelDataProviderURL' => [0x0028, 0x7fe0, 'UR', '1'],
        'DataPointRows' => [0x0028, 0x9001, 'UL', '1'],
        'DataPointColumns' => [0x0028, 0x9002, 'UL', '1'],
        'SignalDomainColumns' => [0x0028, 0x9003, 'CS', '1'],
        'DataRepresentation' => [0x0028, 0x9108, 'CS', '1'],
        'PixelMeasuresSequence' => [0x0028, 0x9110, 'SQ', '1'],
        'FrameVOILUTSequence' => [0x0028, 0x9132, 'SQ', '1'],
        'PixelValueTransformationSequence' => [0x0028, 0x9145, 'SQ', '1'],
        'SignalDomainRows' => [0x0028, 0x9235, 'CS', '1'],
        'DisplayFilterPercentage' => [0x0028, 0x9411, 'FL', '1'],
        'FramePixelShiftSequence' => [0x0028, 0x9415, 'SQ', '1'],
        'SubtractionItemID' => [0x0028, 0x9416, 'US', '1'],
        'PixelIntensityRelationshipLUTSequence' => [0x0028, 0x9422, 'SQ', '1'],
        'FramePixelDataPropertiesSequence' => [0x0028, 0x9443, 'SQ', '1'],
        'GeometricalProperties' => [0x0028, 0x9444, 'CS', '1'],
        'GeometricMaximumDistortion' => [0x0028, 0x9445, 'FL', '1'],
        'ImageProcessingApplied' => [0x0028, 0x9446, 'CS', '1-n'],
        'MaskSelectionMode' => [0x0028, 0x9454, 'CS', '1'],
        'LUTFunction' => [0x0028, 0x9474, 'CS', '1'],
        'MaskVisibilityPercentage' => [0x0028, 0x9478, 'FL', '1'],
        'PixelShiftSequence' => [0x0028, 0x9501, 'SQ', '1'],
        'RegionPixelShiftSequence' => [0x0028, 0x9502, 'SQ', '1'],
        'VerticesOfTheRegion' => [0x0028, 0x9503, 'SS', '2-2n'],
        'MultiFramePresentationSequence' => [0x0028, 0x9505, 'SQ', '1'],
        'PixelShiftFrameRange' => [0x0028, 0x9506, 'US', '2-2n'],
        'LUTFrameRange' => [0x0028, 0x9507, 'US', '2-2n'],
        'ImageToEquipmentMappingMatrix' => [0x0028, 0x9520, 'DS', '16'],
        'EquipmentCoordinateSystemIdentification' => [0x0028, 0x9537, 'CS', '1'],
        'RequestingPhysicianIdentificationSequence' => [0x0032, 0x1031, 'SQ', '1'],
        'RequestingPhysician' => [0x0032, 0x1032, 'PN', '1'],
        'RequestingService' => [0x0032, 0x1033, 'LO', '1'],
        'RequestingServiceCodeSequence' => [0x0032, 0x1034, 'SQ', '1'],
        'RequestedProcedureDescription' => [0x0032, 0x1060, 'LO', '1'],
        'RequestedProcedureCodeSequence' => [0x0032, 0x1064, 'SQ', '1'],
        'RequestedLateralityCodeSequence' => [0x0032, 0x1065, 'SQ', '1'],
        'ReasonForVisit' => [0x0032, 0x1066, 'UT', '1'],
        'ReasonForVisitCodeSequence' => [0x0032, 0x1067, 'SQ', '1'],
        'RequestedContrastAgent' => [0x0032, 0x1070, 'LO', '1'],
        'FlowIdentifierSequence' => [0x0034, 0x0001, 'SQ', '1'],
        'FlowIdentifier' => [0x0034, 0x0002, 'OB', '1'],
        'FlowTransferSyntaxUID' => [0x0034, 0x0003, 'UI', '1'],
        'FlowRTPSamplingRate' => [0x0034, 0x0004, 'UL', '1'],
        'SourceIdentifier' => [0x0034, 0x0005, 'OB', '1'],
        'FrameOriginTimestamp' => [0x0034, 0x0007, 'OB', '1'],
        'IncludesImagingSubject' => [0x0034, 0x0008, 'CS', '1'],
        'FrameUsefulnessGroupSequence' => [0x0034, 0x0009, 'SQ', '1'],
        'RealTimeBulkDataFlowSequence' => [0x0034, 0x000a, 'SQ', '1'],
        'CameraPositionGroupSequence' => [0x0034, 0x000b, 'SQ', '1'],
        'IncludesInformation' => [0x0034, 0x000c, 'CS', '1'],
        'TimeOfFrameGroupSequence' => [0x0034, 0x000d, 'SQ', '1'],
        'VisitStatusID' => [0x0038, 0x0008, 'CS', '1'],
        'AdmissionID' => [0x0038, 0x0010, 'LO', '1'],
        'IssuerOfAdmissionIDSequence' => [0x0038, 0x0014, 'SQ', '1'],
        'RouteOfAdmissions' => [0x0038, 0x0016, 'LO', '1'],
        'AdmittingDate' => [0x0038, 0x0020, 'DA', '1'],
        'AdmittingTime' => [0x0038, 0x0021, 'TM', '1'],
        'SpecialNeeds' => [0x0038, 0x0050, 'LO', '1'],
        'ServiceEpisodeID' => [0x0038, 0x0060, 'LO', '1'],
        'ServiceEpisodeDescription' => [0x0038, 0x0062, 'LO', '1'],
        'IssuerOfServiceEpisodeIDSequence' => [0x0038, 0x0064, 'SQ', '1'],
        'PertinentDocumentsSequence' => [0x0038, 0x0100, 'SQ', '1'],
        'PertinentResourcesSequence' => [0x0038, 0x0101, 'SQ', '1'],
        'ResourceDescription' => [0x0038, 0x0102, 'LO', '1'],
        'CurrentPatientLocation' => [0x0038, 0x0300, 'LO', '1'],
        'PatientInstitutionResidence' => [0x0038, 0x0400, 'LO', '1'],
        'PatientState' => [0x0038, 0x0500, 'LO', '1'],
        'PatientClinicalTrialParticipationSequence' => [0x0038, 0x0502, 'SQ', '1'],
        'VisitComments' => [0x0038, 0x4000, 'LT', '1'],
        'WaveformOriginality' => [0x003a, 0x0004, 'CS', '1'],
        'NumberOfWaveformChannels' => [0x003a, 0x0005, 'US', '1'],
        'NumberOfWaveformSamples' => [0x003a, 0x0010, 'UL', '1'],
        'SamplingFrequency' => [0x003a, 0x001a, 'DS', '1'],
        'MultiplexGroupLabel' => [0x003a, 0x0020, 'SH', '1'],
        'ChannelDefinitionSequence' => [0x003a, 0x0200, 'SQ', '1'],
        'WaveformChannelNumber' => [0x003a, 0x0202, 'IS', '1'],
        'ChannelLabel' => [0x003a, 0x0203, 'SH', '1'],
        'ChannelStatus' => [0x003a, 0x0205, 'CS', '1-n'],
        'ChannelSourceSequence' => [0x003a, 0x0208, 'SQ', '1'],
        'ChannelSourceModifiersSequence' => [0x003a, 0x0209, 'SQ', '1'],
        'SourceWaveformSequence' => [0x003a, 0x020a, 'SQ', '1'],
        'ChannelDerivationDescription' => [0x003a, 0x020c, 'LO', '1'],
        'ChannelSensitivity' => [0x003a, 0x0210, 'DS', '1'],
        'ChannelSensitivityUnitsSequence' => [0x003a, 0x0211, 'SQ', '1'],
        'ChannelSensitivityCorrectionFactor' => [0x003a, 0x0212, 'DS', '1'],
        'ChannelBaseline' => [0x003a, 0x0213, 'DS', '1'],
        'ChannelTimeSkew' => [0x003a, 0x0214, 'DS', '1'],
        'ChannelSampleSkew' => [0x003a, 0x0215, 'DS', '1'],
        'ChannelOffset' => [0x003a, 0x0218, 'DS', '1'],
        'WaveformBitsStored' => [0x003a, 0x021a, 'US', '1'],
        'FilterLowFrequency' => [0x003a, 0x0220, 'DS', '1'],
        'FilterHighFrequency' => [0x003a, 0x0221, 'DS', '1'],
        'NotchFilterFrequency' => [0x003a, 0x0222, 'DS', '1'],
        'NotchFilterBandwidth' => [0x003a, 0x0223, 'DS', '1'],
        'WaveformDataDisplayScale' => [0x003a, 0x0230, 'FL', '1'],
        'WaveformDisplayBackgroundCIELabValue' => [0x003a, 0x0231, 'US', '3'],
        'WaveformPresentationGroupSequence' => [0x003a, 0x0240, 'SQ', '1'],
        'PresentationGroupNumber' => [0x003a, 0x0241, 'US', '1'],
        'ChannelDisplaySequence' => [0x003a, 0x0242, 'SQ', '1'],
        'ChannelRecommendedDisplayCIELabValue' => [0x003a, 0x0244, 'US', '3'],
        'ChannelPosition' => [0x003a, 0x0245, 'FL', '1'],
        'DisplayShadingFlag' => [0x003a, 0x0246, 'CS', '1'],
        'FractionalChannelDisplayScale' => [0x003a, 0x0247, 'FL', '1'],
        'AbsoluteChannelDisplayScale' => [0x003a, 0x0248, 'FL', '1'],
        'MultiplexedAudioChannelsDescriptionCodeSequence' => [0x003a, 0x0300, 'SQ', '1'],
        'ChannelIdentificationCode' => [0x003a, 0x0301, 'IS', '1'],
        'ChannelMode' => [0x003a, 0x0302, 'CS', '1'],
        'MultiplexGroupUID' => [0x003a, 0x0310, 'UI', '1'],
        'PowerlineFrequency' => [0x003a, 0x0311, 'DS', '1'],
        'ChannelImpedanceSequence' => [0x003a, 0x0312, 'SQ', '1'],
        'ImpedanceValue' => [0x003a, 0x0313, 'DS', '1'],
        'ImpedanceMeasurementDateTime' => [0x003a, 0x0314, 'DT', '1'],
        'ImpedanceMeasurementFrequency' => [0x003a, 0x0315, 'DS', '1'],
        'ImpedanceMeasurementCurrentType' => [0x003a, 0x0316, 'CS', '1'],
        'WaveformAmplifierType' => [0x003a, 0x0317, 'CS', '1'],
        'FilterLowFrequencyCharacteristicsSequence' => [0x003a, 0x0318, 'SQ', '1'],
        'FilterHighFrequencyCharacteristicsSequence' => [0x003a, 0x0319, 'SQ', '1'],
        'SummarizedFilterLookupTableSequence' => [0x003a, 0x0320, 'SQ', '1'],
        'NotchFilterCharacteristicsSequence' => [0x003a, 0x0321, 'SQ', '1'],
        'WaveformFilterType' => [0x003a, 0x0322, 'CS', '1'],
        'AnalogFilterCharacteristicsSequence' => [0x003a, 0x0323, 'SQ', '1'],
        'AnalogFilterRollOff' => [0x003a, 0x0324, 'DS', '1'],
        'AnalogFilterTypeCodeSequence' => [0x003a, 0x0325, 'SQ', '1'],
        'DigitalFilterCharacteristicsSequence' => [0x003a, 0x0326, 'SQ', '1'],
        'DigitalFilterOrder' => [0x003a, 0x0327, 'IS', '1'],
        'DigitalFilterTypeCodeSequence' => [0x003a, 0x0328, 'SQ', '1'],
        'WaveformFilterDescription' => [0x003a, 0x0329, 'ST', '1'],
        'FilterLookupTableSequence' => [0x003a, 0x032a, 'SQ', '1'],
        'FilterLookupTableDescription' => [0x003a, 0x032b, 'ST', '1'],
        'FrequencyEncodingCodeSequence' => [0x003a, 0x032c, 'SQ', '1'],
        'MagnitudeEncodingCodeSequence' => [0x003a, 0x032d, 'SQ', '1'],
        'FilterLookupTableData' => [0x003a, 0x032e, 'OD', '1'],
        'ScheduledStationAETitle' => [0x0040, 0x0001, 'AE', '1-n'],
        'ScheduledProcedureStepStartDate' => [0x0040, 0x0002, 'DA', '1'],
        'ScheduledProcedureStepStartTime' => [0x0040, 0x0003, 'TM', '1'],
        'ScheduledProcedureStepEndDate' => [0x0040, 0x0004, 'DA', '1'],
        'ScheduledProcedureStepEndTime' => [0x0040, 0x0005, 'TM', '1'],
        'ScheduledPerformingPhysicianName' => [0x0040, 0x0006, 'PN', '1'],
        'ScheduledProcedureStepDescription' => [0x0040, 0x0007, 'LO', '1'],
        'ScheduledProtocolCodeSequence' => [0x0040, 0x0008, 'SQ', '1'],
        'ScheduledProcedureStepID' => [0x0040, 0x0009, 'SH', '1'],
        'StageCodeSequence' => [0x0040, 0x000a, 'SQ', '1'],
        'ScheduledPerformingPhysicianIdentificationSequence' => [0x0040, 0x000b, 'SQ', '1'],
        'ScheduledStationName' => [0x0040, 0x0010, 'SH', '1-n'],
        'ScheduledProcedureStepLocation' => [0x0040, 0x0011, 'SH', '1'],
        'PreMedication' => [0x0040, 0x0012, 'LO', '1'],
        'ScheduledProcedureStepStatus' => [0x0040, 0x0020, 'CS', '1'],
        'OrderPlacerIdentifierSequence' => [0x0040, 0x0026, 'SQ', '1'],
        'OrderFillerIdentifierSequence' => [0x0040, 0x0027, 'SQ', '1'],
        'LocalNamespaceEntityID' => [0x0040, 0x0031, 'UT', '1'],
        'UniversalEntityID' => [0x0040, 0x0032, 'UT', '1'],
        'UniversalEntityIDType' => [0x0040, 0x0033, 'CS', '1'],
        'IdentifierTypeCode' => [0x0040, 0x0035, 'CS', '1'],
        'AssigningFacilitySequence' => [0x0040, 0x0036, 'SQ', '1'],
        'AssigningJurisdictionCodeSequence' => [0x0040, 0x0039, 'SQ', '1'],
        'AssigningAgencyOrDepartmentCodeSequence' => [0x0040, 0x003a, 'SQ', '1'],
        'ScheduledProcedureStepSequence' => [0x0040, 0x0100, 'SQ', '1'],
        'ReferencedNonImageCompositeSOPInstanceSequence' => [0x0040, 0x0220, 'SQ', '1'],
        'PerformedStationAETitle' => [0x0040, 0x0241, 'AE', '1'],
        'PerformedStationName' => [0x0040, 0x0242, 'SH', '1'],
        'PerformedLocation' => [0x0040, 0x0243, 'SH', '1'],
        'PerformedProcedureStepStartDate' => [0x0040, 0x0244, 'DA', '1'],
        'PerformedProcedureStepStartTime' => [0x0040, 0x0245, 'TM', '1'],
        'PerformedProcedureStepEndDate' => [0x0040, 0x0250, 'DA', '1'],
        'PerformedProcedureStepEndTime' => [0x0040, 0x0251, 'TM', '1'],
        'PerformedProcedureStepStatus' => [0x0040, 0x0252, 'CS', '1'],
        'PerformedProcedureStepID' => [0x0040, 0x0253, 'SH', '1'],
        'PerformedProcedureStepDescription' => [0x0040, 0x0254, 'LO', '1'],
        'PerformedProcedureTypeDescription' => [0x0040, 0x0255, 'LO', '1'],
        'PerformedProtocolCodeSequence' => [0x0040, 0x0260, 'SQ', '1'],
        'PerformedProtocolType' => [0x0040, 0x0261, 'CS', '1'],
        'ScheduledStepAttributesSequence' => [0x0040, 0x0270, 'SQ', '1'],
        'RequestAttributesSequence' => [0x0040, 0x0275, 'SQ', '1'],
        'CommentsOnThePerformedProcedureStep' => [0x0040, 0x0280, 'ST', '1'],
        'PerformedProcedureStepDiscontinuationReasonCodeSequence' => [0x0040, 0x0281, 'SQ', '1'],
        'QuantitySequence' => [0x0040, 0x0293, 'SQ', '1'],
        'Quantity' => [0x0040, 0x0294, 'DS', '1'],
        'MeasuringUnitsSequence' => [0x0040, 0x0295, 'SQ', '1'],
        'BillingItemSequence' => [0x0040, 0x0296, 'SQ', '1'],
        'EntranceDose' => [0x0040, 0x0302, 'US', '1'],
        'ExposedArea' => [0x0040, 0x0303, 'US', '1-2'],
        'DistanceSourceToEntrance' => [0x0040, 0x0306, 'DS', '1'],
        'CommentsOnRadiationDose' => [0x0040, 0x0310, 'ST', '1'],
        'XRayOutput' => [0x0040, 0x0312, 'DS', '1'],
        'HalfValueLayer' => [0x0040, 0x0314, 'DS', '1'],
        'OrganDose' => [0x0040, 0x0316, 'DS', '1'],
        'OrganExposed' => [0x0040, 0x0318, 'CS', '1'],
        'BillingProcedureStepSequence' => [0x0040, 0x0320, 'SQ', '1'],
        'FilmConsumptionSequence' => [0x0040, 0x0321, 'SQ', '1'],
        'BillingSuppliesAndDevicesSequence' => [0x0040, 0x0324, 'SQ', '1'],
        'PerformedSeriesSequence' => [0x0040, 0x0340, 'SQ', '1'],
        'CommentsOnTheScheduledProcedureStep' => [0x0040, 0x0400, 'LT', '1'],
        'ProtocolContextSequence' => [0x0040, 0x0440, 'SQ', '1'],
        'ContentItemModifierSequence' => [0x0040, 0x0441, 'SQ', '1'],
        'ScheduledSpecimenSequence' => [0x0040, 0x0500, 'SQ', '1'],
        'ContainerIdentifier' => [0x0040, 0x0512, 'LO', '1'],
        'IssuerOfTheContainerIdentifierSequence' => [0x0040, 0x0513, 'SQ', '1'],
        'AlternateContainerIdentifierSequence' => [0x0040, 0x0515, 'SQ', '1'],
        'ContainerTypeCodeSequence' => [0x0040, 0x0518, 'SQ', '1'],
        'ContainerDescription' => [0x0040, 0x051a, 'LO', '1'],
        'ContainerComponentSequence' => [0x0040, 0x0520, 'SQ', '1'],
        'SpecimenIdentifier' => [0x0040, 0x0551, 'LO', '1'],
        'SpecimenUID' => [0x0040, 0x0554, 'UI', '1'],
        'AcquisitionContextSequence' => [0x0040, 0x0555, 'SQ', '1'],
        'AcquisitionContextDescription' => [0x0040, 0x0556, 'ST', '1'],
        'SpecimenDescriptionSequence' => [0x0040, 0x0560, 'SQ', '1'],
        'IssuerOfTheSpecimenIdentifierSequence' => [0x0040, 0x0562, 'SQ', '1'],
        'SpecimenTypeCodeSequence' => [0x0040, 0x059a, 'SQ', '1'],
        'SpecimenShortDescription' => [0x0040, 0x0600, 'LO', '1'],
        'SpecimenDetailedDescription' => [0x0040, 0x0602, 'UT', '1'],
        'SpecimenPreparationSequence' => [0x0040, 0x0610, 'SQ', '1'],
        'SpecimenPreparationStepContentItemSequence' => [0x0040, 0x0612, 'SQ', '1'],
        'SpecimenLocalizationContentItemSequence' => [0x0040, 0x0620, 'SQ', '1'],
        'WholeSlideMicroscopyImageFrameTypeSequence' => [0x0040, 0x0710, 'SQ', '1'],
        'ImageCenterPointCoordinatesSequence' => [0x0040, 0x071a, 'SQ', '1'],
        'XOffsetInSlideCoordinateSystem' => [0x0040, 0x072a, 'DS', '1'],
        'YOffsetInSlideCoordinateSystem' => [0x0040, 0x073a, 'DS', '1'],
        'ZOffsetInSlideCoordinateSystem' => [0x0040, 0x074a, 'DS', '1'],
        'MeasurementUnitsCodeSequence' => [0x0040, 0x08ea, 'SQ', '1'],
        'RequestedProcedureID' => [0x0040, 0x1001, 'SH', '1'],
        'ReasonForTheRequestedProcedure' => [0x0040, 0x1002, 'LO', '1'],
        'RequestedProcedurePriority' => [0x0040, 0x1003, 'SH', '1'],
        'PatientTransportArrangements' => [0x0040, 0x1004, 'LO', '1'],
        'RequestedProcedureLocation' => [0x0040, 0x1005, 'LO', '1'],
        'ConfidentialityCode' => [0x0040, 0x1008, 'LO', '1'],
        'ReportingPriority' => [0x0040, 0x1009, 'SH', '1'],
        'ReasonForRequestedProcedureCodeSequence' => [0x0040, 0x100a, 'SQ', '1'],
        'NamesOfIntendedRecipientsOfResults' => [0x0040, 0x1010, 'PN', '1-n'],
        'IntendedRecipientsOfResultsIdentificationSequence' => [0x0040, 0x1011, 'SQ', '1'],
        'ReasonForPerformedProcedureCodeSequence' => [0x0040, 0x1012, 'SQ', '1'],
        'PersonIdentificationCodeSequence' => [0x0040, 0x1101, 'SQ', '1'],
        'PersonAddress' => [0x0040, 0x1102, 'ST', '1'],
        'PersonTelephoneNumbers' => [0x0040, 0x1103, 'LO', '1-n'],
        'PersonTelecomInformation' => [0x0040, 0x1104, 'LT', '1'],
        'RequestedProcedureComments' => [0x0040, 0x1400, 'LT', '1'],
        'IssueDateOfImagingServiceRequest' => [0x0040, 0x2004, 'DA', '1'],
        'IssueTimeOfImagingServiceRequest' => [0x0040, 0x2005, 'TM', '1'],
        'OrderEnteredBy' => [0x0040, 0x2008, 'PN', '1'],
        'OrderEntererLocation' => [0x0040, 0x2009, 'SH', '1'],
        'OrderCallbackPhoneNumber' => [0x0040, 0x2010, 'SH', '1'],
        'OrderCallbackTelecomInformation' => [0x0040, 0x2011, 'LT', '1'],
        'PlacerOrderNumberImagingServiceRequest' => [0x0040, 0x2016, 'LO', '1'],
        'FillerOrderNumberImagingServiceRequest' => [0x0040, 0x2017, 'LO', '1'],
        'ImagingServiceRequestComments' => [0x0040, 0x2400, 'LT', '1'],
        'ConfidentialityConstraintOnPatientDataDescription' => [0x0040, 0x3001, 'LO', '1'],
        'ScheduledProcedureStepStartDateTime' => [0x0040, 0x4005, 'DT', '1'],
        'ScheduledProcedureStepExpirationDateTime' => [0x0040, 0x4008, 'DT', '1'],
        'HumanPerformerCodeSequence' => [0x0040, 0x4009, 'SQ', '1'],
        'ScheduledProcedureStepModificationDateTime' => [0x0040, 0x4010, 'DT', '1'],
        'ExpectedCompletionDateTime' => [0x0040, 0x4011, 'DT', '1'],
        'ScheduledWorkitemCodeSequence' => [0x0040, 0x4018, 'SQ', '1'],
        'PerformedWorkitemCodeSequence' => [0x0040, 0x4019, 'SQ', '1'],
        'InputInformationSequence' => [0x0040, 0x4021, 'SQ', '1'],
        'ScheduledStationNameCodeSequence' => [0x0040, 0x4025, 'SQ', '1'],
        'ScheduledStationClassCodeSequence' => [0x0040, 0x4026, 'SQ', '1'],
        'ScheduledStationGeographicLocationCodeSequence' => [0x0040, 0x4027, 'SQ', '1'],
        'PerformedStationNameCodeSequence' => [0x0040, 0x4028, 'SQ', '1'],
        'PerformedStationClassCodeSequence' => [0x0040, 0x4029, 'SQ', '1'],
        'PerformedStationGeographicLocationCodeSequence' => [0x0040, 0x4030, 'SQ', '1'],
        'OutputInformationSequence' => [0x0040, 0x4033, 'SQ', '1'],
        'ScheduledHumanPerformersSequence' => [0x0040, 0x4034, 'SQ', '1'],
        'ActualHumanPerformersSequence' => [0x0040, 0x4035, 'SQ', '1'],
        'HumanPerformerOrganization' => [0x0040, 0x4036, 'LO', '1'],
        'HumanPerformerName' => [0x0040, 0x4037, 'PN', '1'],
        'RawDataHandling' => [0x0040, 0x4040, 'CS', '1'],
        'InputReadinessState' => [0x0040, 0x4041, 'CS', '1'],
        'PerformedProcedureStepStartDateTime' => [0x0040, 0x4050, 'DT', '1'],
        'PerformedProcedureStepEndDateTime' => [0x0040, 0x4051, 'DT', '1'],
        'ProcedureStepCancellationDateTime' => [0x0040, 0x4052, 'DT', '1'],
        'OutputDestinationSequence' => [0x0040, 0x4070, 'SQ', '1'],
        'DICOMStorageSequence' => [0x0040, 0x4071, 'SQ', '1'],
        'STOWRSStorageSequence' => [0x0040, 0x4072, 'SQ', '1'],
        'StorageURL' => [0x0040, 0x4073, 'UR', '1'],
        'XDSStorageSequence' => [0x0040, 0x4074, 'SQ', '1'],
        'EntranceDoseInmGy' => [0x0040, 0x8302, 'DS', '1'],
        'EntranceDoseDerivation' => [0x0040, 0x8303, 'CS', '1'],
        'ParametricMapFrameTypeSequence' => [0x0040, 0x9092, 'SQ', '1'],
        'ReferencedImageRealWorldValueMappingSequence' => [0x0040, 0x9094, 'SQ', '1'],
        'RealWorldValueMappingSequence' => [0x0040, 0x9096, 'SQ', '1'],
        'PixelValueMappingCodeSequence' => [0x0040, 0x9098, 'SQ', '1'],
        'LUTLabel' => [0x0040, 0x9210, 'SH', '1'],
        'RealWorldValueLastValueMapped' => [0x0040, 0x9211, 'xs', '1'],
        'RealWorldValueLUTData' => [0x0040, 0x9212, 'FD', '1-n'],
        'DoubleFloatRealWorldValueLastValueMapped' => [0x0040, 0x9213, 'FD', '1'],
        'DoubleFloatRealWorldValueFirstValueMapped' => [0x0040, 0x9214, 'FD', '1'],
        'RealWorldValueFirstValueMapped' => [0x0040, 0x9216, 'xs', '1'],
        'QuantityDefinitionSequence' => [0x0040, 0x9220, 'SQ', '1'],
        'RealWorldValueIntercept' => [0x0040, 0x9224, 'FD', '1'],
        'RealWorldValueSlope' => [0x0040, 0x9225, 'FD', '1'],
        'RelationshipType' => [0x0040, 0xa010, 'CS', '1'],
        'VerifyingOrganization' => [0x0040, 0xa027, 'LO', '1'],
        'VerificationDateTime' => [0x0040, 0xa030, 'DT', '1'],
        'ObservationDateTime' => [0x0040, 0xa032, 'DT', '1'],
        'ObservationStartDateTime' => [0x0040, 0xa033, 'DT', '1'],
        'EffectiveStartDateTime' => [0x0040, 0xa034, 'DT', '1'],
        'EffectiveStopDateTime' => [0x0040, 0xa035, 'DT', '1'],
        'ValueType' => [0x0040, 0xa040, 'CS', '1'],
        'ConceptNameCodeSequence' => [0x0040, 0xa043, 'SQ', '1'],
        'ContinuityOfContent' => [0x0040, 0xa050, 'CS', '1'],
        'VerifyingObserverSequence' => [0x0040, 0xa073, 'SQ', '1'],
        'VerifyingObserverName' => [0x0040, 0xa075, 'PN', '1'],
        'AuthorObserverSequence' => [0x0040, 0xa078, 'SQ', '1'],
        'ParticipantSequence' => [0x0040, 0xa07a, 'SQ', '1'],
        'CustodialOrganizationSequence' => [0x0040, 0xa07c, 'SQ', '1'],
        'ParticipationType' => [0x0040, 0xa080, 'CS', '1'],
        'ParticipationDateTime' => [0x0040, 0xa082, 'DT', '1'],
        'ObserverType' => [0x0040, 0xa084, 'CS', '1'],
        'VerifyingObserverIdentificationCodeSequence' => [0x0040, 0xa088, 'SQ', '1'],
        'ReferencedWaveformChannels' => [0x0040, 0xa0b0, 'US', '2-2n'],
        'DateTime' => [0x0040, 0xa120, 'DT', '1'],
        'Date' => [0x0040, 0xa121, 'DA', '1'],
        'Time' => [0x0040, 0xa122, 'TM', '1'],
        'PersonName' => [0x0040, 0xa123, 'PN', '1'],
        'UID' => [0x0040, 0xa124, 'UI', '1'],
        'TemporalRangeType' => [0x0040, 0xa130, 'CS', '1'],
        'ReferencedSamplePositions' => [0x0040, 0xa132, 'UL', '1-n'],
        'ReferencedTimeOffsets' => [0x0040, 0xa138, 'DS', '1-n'],
        'ReferencedDateTime' => [0x0040, 0xa13a, 'DT', '1-n'],
        'TextValue' => [0x0040, 0xa160, 'UT', '1'],
        'FloatingPointValue' => [0x0040, 0xa161, 'FD', '1-n'],
        'RationalNumeratorValue' => [0x0040, 0xa162, 'SL', '1-n'],
        'RationalDenominatorValue' => [0x0040, 0xa163, 'UL', '1-n'],
        'ConceptCodeSequence' => [0x0040, 0xa168, 'SQ', '1'],
        'PurposeOfReferenceCodeSequence' => [0x0040, 0xa170, 'SQ', '1'],
        'ObservationUID' => [0x0040, 0xa171, 'UI', '1'],
        'AnnotationGroupNumber' => [0x0040, 0xa180, 'US', '1'],
        'ModifierCodeSequence' => [0x0040, 0xa195, 'SQ', '1'],
        'MeasuredValueSequence' => [0x0040, 0xa300, 'SQ', '1'],
        'NumericValueQualifierCodeSequence' => [0x0040, 0xa301, 'SQ', '1'],
        'NumericValue' => [0x0040, 0xa30a, 'DS', '1-n'],
        'PredecessorDocumentsSequence' => [0x0040, 0xa360, 'SQ', '1'],
        'ReferencedRequestSequence' => [0x0040, 0xa370, 'SQ', '1'],
        'PerformedProcedureCodeSequence' => [0x0040, 0xa372, 'SQ', '1'],
        'CurrentRequestedProcedureEvidenceSequence' => [0x0040, 0xa375, 'SQ', '1'],
        'PertinentOtherEvidenceSequence' => [0x0040, 0xa385, 'SQ', '1'],
        'HL7StructuredDocumentReferenceSequence' => [0x0040, 0xa390, 'SQ', '1'],
        'CompletionFlag' => [0x0040, 0xa491, 'CS', '1'],
        'CompletionFlagDescription' => [0x0040, 0xa492, 'LO', '1'],
        'VerificationFlag' => [0x0040, 0xa493, 'CS', '1'],
        'ArchiveRequested' => [0x0040, 0xa494, 'CS', '1'],
        'PreliminaryFlag' => [0x0040, 0xa496, 'CS', '1'],
        'ContentTemplateSequence' => [0x0040, 0xa504, 'SQ', '1'],
        'IdenticalDocumentsSequence' => [0x0040, 0xa525, 'SQ', '1'],
        'ContentSequence' => [0x0040, 0xa730, 'SQ', '1'],
        'TabulatedValuesSequence' => [0x0040, 0xa801, 'SQ', '1'],
        'NumberOfTableRows' => [0x0040, 0xa802, 'UL', '1'],
        'NumberOfTableColumns' => [0x0040, 0xa803, 'UL', '1'],
        'TableRowNumber' => [0x0040, 0xa804, 'UL', '1'],
        'TableColumnNumber' => [0x0040, 0xa805, 'UL', '1'],
        'TableRowDefinitionSequence' => [0x0040, 0xa806, 'SQ', '1'],
        'TableColumnDefinitionSequence' => [0x0040, 0xa807, 'SQ', '1'],
        'CellValuesSequence' => [0x0040, 0xa808, 'SQ', '1'],
        'WaveformAnnotationSequence' => [0x0040, 0xb020, 'SQ', '1'],
        'StructuredWaveformAnnotationSequence' => [0x0040, 0xb030, 'SQ', '1'],
        'WaveformAnnotationDisplaySelectionSequence' => [0x0040, 0xb031, 'SQ', '1'],
        'ReferencedMontageIndex' => [0x0040, 0xb032, 'US', '1'],
        'WaveformTextualAnnotationSequence' => [0x0040, 0xb033, 'SQ', '1'],
        'AnnotationDateTime' => [0x0040, 0xb034, 'DT', '1'],
        'DisplayedWaveformSegmentSequence' => [0x0040, 0xb035, 'SQ', '1'],
        'SegmentDefinitionDateTime' => [0x0040, 0xb036, 'DT', '1'],
        'MontageActivationSequence' => [0x0040, 0xb037, 'SQ', '1'],
        'MontageActivationTimeOffset' => [0x0040, 0xb038, 'DS', '1'],
        'WaveformMontageSequence' => [0x0040, 0xb039, 'SQ', '1'],
        'ReferencedMontageChannelNumber' => [0x0040, 0xb03a, 'IS', '1'],
        'MontageName' => [0x0040, 0xb03b, 'LT', '1'],
        'MontageChannelSequence' => [0x0040, 0xb03c, 'SQ', '1'],
        'MontageIndex' => [0x0040, 0xb03d, 'US', '1'],
        'MontageChannelNumber' => [0x0040, 0xb03e, 'IS', '1'],
        'MontageChannelLabel' => [0x0040, 0xb03f, 'LO', '1'],
        'MontageChannelSourceCodeSequence' => [0x0040, 0xb040, 'SQ', '1'],
        'ContributingChannelSourcesSequence' => [0x0040, 0xb041, 'SQ', '1'],
        'ChannelWeight' => [0x0040, 0xb042, 'FL', '1'],
        'TemplateIdentifier' => [0x0040, 0xdb00, 'CS', '1'],
        'ReferencedContentItemIdentifier' => [0x0040, 0xdb73, 'UL', '1-n'],
        'HL7InstanceIdentifier' => [0x0040, 0xe001, 'ST', '1'],
        'HL7DocumentEffectiveTime' => [0x0040, 0xe004, 'DT', '1'],
        'HL7DocumentTypeCodeSequence' => [0x0040, 0xe006, 'SQ', '1'],
        'DocumentClassCodeSequence' => [0x0040, 0xe008, 'SQ', '1'],
        'RetrieveURI' => [0x0040, 0xe010, 'UR', '1'],
        'RetrieveLocationUID' => [0x0040, 0xe011, 'UI', '1'],
        'TypeOfInstances' => [0x0040, 0xe020, 'CS', '1'],
        'DICOMRetrievalSequence' => [0x0040, 0xe021, 'SQ', '1'],
        'DICOMMediaRetrievalSequence' => [0x0040, 0xe022, 'SQ', '1'],
        'WADORetrievalSequence' => [0x0040, 0xe023, 'SQ', '1'],
        'XDSRetrievalSequence' => [0x0040, 0xe024, 'SQ', '1'],
        'WADORSRetrievalSequence' => [0x0040, 0xe025, 'SQ', '1'],
        'RepositoryUniqueID' => [0x0040, 0xe030, 'UI', '1'],
        'HomeCommunityID' => [0x0040, 0xe031, 'UI', '1'],
        'DocumentTitle' => [0x0042, 0x0010, 'ST', '1'],
        'EncapsulatedDocument' => [0x0042, 0x0011, 'OB', '1'],
        'MIMETypeOfEncapsulatedDocument' => [0x0042, 0x0012, 'LO', '1'],
        'SourceInstanceSequence' => [0x0042, 0x0013, 'SQ', '1'],
        'ListOfMIMETypes' => [0x0042, 0x0014, 'LO', '1-n'],
        'EncapsulatedDocumentLength' => [0x0042, 0x0015, 'UL', '1'],
        'ProductPackageIdentifier' => [0x0044, 0x0001, 'ST', '1'],
        'SubstanceAdministrationApproval' => [0x0044, 0x0002, 'CS', '1'],
        'ApprovalStatusFurtherDescription' => [0x0044, 0x0003, 'LT', '1'],
        'ApprovalStatusDateTime' => [0x0044, 0x0004, 'DT', '1'],
        'ProductTypeCodeSequence' => [0x0044, 0x0007, 'SQ', '1'],
        'ProductName' => [0x0044, 0x0008, 'LO', '1-n'],
        'ProductDescription' => [0x0044, 0x0009, 'LT', '1'],
        'ProductLotIdentifier' => [0x0044, 0x000a, 'LO', '1'],
        'ProductExpirationDateTime' => [0x0044, 0x000b, 'DT', '1'],
        'SubstanceAdministrationDateTime' => [0x0044, 0x0010, 'DT', '1'],
        'SubstanceAdministrationNotes' => [0x0044, 0x0011, 'LO', '1'],
        'SubstanceAdministrationDeviceID' => [0x0044, 0x0012, 'LO', '1'],
        'ProductParameterSequence' => [0x0044, 0x0013, 'SQ', '1'],
        'SubstanceAdministrationParameterSequence' => [0x0044, 0x0019, 'SQ', '1'],
        'ApprovalSequence' => [0x0044, 0x0100, 'SQ', '1'],
        'AssertionCodeSequence' => [0x0044, 0x0101, 'SQ', '1'],
        'AssertionUID' => [0x0044, 0x0102, 'UI', '1'],
        'AsserterIdentificationSequence' => [0x0044, 0x0103, 'SQ', '1'],
        'AssertionDateTime' => [0x0044, 0x0104, 'DT', '1'],
        'AssertionExpirationDateTime' => [0x0044, 0x0105, 'DT', '1'],
        'AssertionComments' => [0x0044, 0x0106, 'UT', '1'],
        'RelatedAssertionSequence' => [0x0044, 0x0107, 'SQ', '1'],
        'ReferencedAssertionUID' => [0x0044, 0x0108, 'UI', '1'],
        'ApprovalSubjectSequence' => [0x0044, 0x0109, 'SQ', '1'],
        'OrganizationalRoleCodeSequence' => [0x0044, 0x010a, 'SQ', '1'],
        'RTAssertionsSequence' => [0x0044, 0x0110, 'SQ', '1'],
        'LensDescription' => [0x0046, 0x0012, 'LO', '1'],
        'RightLensSequence' => [0x0046, 0x0014, 'SQ', '1'],
        'LeftLensSequence' => [0x0046, 0x0015, 'SQ', '1'],
        'UnspecifiedLateralityLensSequence' => [0x0046, 0x0016, 'SQ', '1'],
        'CylinderSequence' => [0x0046, 0x0018, 'SQ', '1'],
        'PrismSequence' => [0x0046, 0x0028, 'SQ', '1'],
        'HorizontalPrismPower' => [0x0046, 0x0030, 'FD', '1'],
        'HorizontalPrismBase' => [0x0046, 0x0032, 'CS', '1'],
        'VerticalPrismPower' => [0x0046, 0x0034, 'FD', '1'],
        'VerticalPrismBase' => [0x0046, 0x0036, 'CS', '1'],
        'LensSegmentType' => [0x0046, 0x0038, 'CS', '1'],
        'OpticalTransmittance' => [0x0046, 0x0040, 'FD', '1'],
        'ChannelWidth' => [0x0046, 0x0042, 'FD', '1'],
        'PupilSize' => [0x0046, 0x0044, 'FD', '1'],
        'CornealSize' => [0x0046, 0x0046, 'FD', '1'],
        'CornealSizeSequence' => [0x0046, 0x0047, 'SQ', '1'],
        'AutorefractionRightEyeSequence' => [0x0046, 0x0050, 'SQ', '1'],
        'AutorefractionLeftEyeSequence' => [0x0046, 0x0052, 'SQ', '1'],
        'DistancePupillaryDistance' => [0x0046, 0x0060, 'FD', '1'],
        'NearPupillaryDistance' => [0x0046, 0x0062, 'FD', '1'],
        'IntermediatePupillaryDistance' => [0x0046, 0x0063, 'FD', '1'],
        'OtherPupillaryDistance' => [0x0046, 0x0064, 'FD', '1'],
        'KeratometryRightEyeSequence' => [0x0046, 0x0070, 'SQ', '1'],
        'KeratometryLeftEyeSequence' => [0x0046, 0x0071, 'SQ', '1'],
        'SteepKeratometricAxisSequence' => [0x0046, 0x0074, 'SQ', '1'],
        'RadiusOfCurvature' => [0x0046, 0x0075, 'FD', '1'],
        'KeratometricPower' => [0x0046, 0x0076, 'FD', '1'],
        'KeratometricAxis' => [0x0046, 0x0077, 'FD', '1'],
        'FlatKeratometricAxisSequence' => [0x0046, 0x0080, 'SQ', '1'],
        'BackgroundColor' => [0x0046, 0x0092, 'CS', '1'],
        'Optotype' => [0x0046, 0x0094, 'CS', '1'],
        'OptotypePresentation' => [0x0046, 0x0095, 'CS', '1'],
        'SubjectiveRefractionRightEyeSequence' => [0x0046, 0x0097, 'SQ', '1'],
        'SubjectiveRefractionLeftEyeSequence' => [0x0046, 0x0098, 'SQ', '1'],
        'AddNearSequence' => [0x0046, 0x0100, 'SQ', '1'],
        'AddIntermediateSequence' => [0x0046, 0x0101, 'SQ', '1'],
        'AddOtherSequence' => [0x0046, 0x0102, 'SQ', '1'],
        'AddPower' => [0x0046, 0x0104, 'FD', '1'],
        'ViewingDistance' => [0x0046, 0x0106, 'FD', '1'],
        'CorneaMeasurementsSequence' => [0x0046, 0x0110, 'SQ', '1'],
        'SourceOfCorneaMeasurementDataCodeSequence' => [0x0046, 0x0111, 'SQ', '1'],
        'SteepCornealAxisSequence' => [0x0046, 0x0112, 'SQ', '1'],
        'FlatCornealAxisSequence' => [0x0046, 0x0113, 'SQ', '1'],
        'CornealPower' => [0x0046, 0x0114, 'FD', '1'],
        'CornealAxis' => [0x0046, 0x0115, 'FD', '1'],
        'CorneaMeasurementMethodCodeSequence' => [0x0046, 0x0116, 'SQ', '1'],
        'RefractiveIndexOfCornea' => [0x0046, 0x0117, 'FL', '1'],
        'RefractiveIndexOfAqueousHumor' => [0x0046, 0x0118, 'FL', '1'],
        'VisualAcuityTypeCodeSequence' => [0x0046, 0x0121, 'SQ', '1'],
        'VisualAcuityRightEyeSequence' => [0x0046, 0x0122, 'SQ', '1'],
        'VisualAcuityLeftEyeSequence' => [0x0046, 0x0123, 'SQ', '1'],
        'VisualAcuityBothEyesOpenSequence' => [0x0046, 0x0124, 'SQ', '1'],
        'ViewingDistanceType' => [0x0046, 0x0125, 'CS', '1'],
        'VisualAcuityModifiers' => [0x0046, 0x0135, 'SS', '2'],
        'DecimalVisualAcuity' => [0x0046, 0x0137, 'FD', '1'],
        'OptotypeDetailedDefinition' => [0x0046, 0x0139, 'LO', '1'],
        'ReferencedRefractiveMeasurementsSequence' => [0x0046, 0x0145, 'SQ', '1'],
        'SpherePower' => [0x0046, 0x0146, 'FD', '1'],
        'CylinderPower' => [0x0046, 0x0147, 'FD', '1'],
        'CornealTopographySurface' => [0x0046, 0x0201, 'CS', '1'],
        'CornealVertexLocation' => [0x0046, 0x0202, 'FL', '2'],
        'PupilCentroidXCoordinate' => [0x0046, 0x0203, 'FL', '1'],
        'PupilCentroidYCoordinate' => [0x0046, 0x0204, 'FL', '1'],
        'EquivalentPupilRadius' => [0x0046, 0x0205, 'FL', '1'],
        'CornealTopographyMapTypeCodeSequence' => [0x0046, 0x0207, 'SQ', '1'],
        'VerticesOfTheOutlineOfPupil' => [0x0046, 0x0208, 'IS', '2-2n'],
        'CornealTopographyMappingNormalsSequence' => [0x0046, 0x0210, 'SQ', '1'],
        'MaximumCornealCurvatureSequence' => [0x0046, 0x0211, 'SQ', '1'],
        'MaximumCornealCurvature' => [0x0046, 0x0212, 'FL', '1'],
        'MaximumCornealCurvatureLocation' => [0x0046, 0x0213, 'FL', '2'],
        'MinimumKeratometricSequence' => [0x0046, 0x0215, 'SQ', '1'],
        'SimulatedKeratometricCylinderSequence' => [0x0046, 0x0218, 'SQ', '1'],
        'AverageCornealPower' => [0x0046, 0x0220, 'FL', '1'],
        'CornealISValue' => [0x0046, 0x0224, 'FL', '1'],
        'AnalyzedArea' => [0x0046, 0x0227, 'FL', '1'],
        'SurfaceRegularityIndex' => [0x0046, 0x0230, 'FL', '1'],
        'SurfaceAsymmetryIndex' => [0x0046, 0x0232, 'FL', '1'],
        'CornealEccentricityIndex' => [0x0046, 0x0234, 'FL', '1'],
        'KeratoconusPredictionIndex' => [0x0046, 0x0236, 'FL', '1'],
        'DecimalPotentialVisualAcuity' => [0x0046, 0x0238, 'FL', '1'],
        'CornealTopographyMapQualityEvaluation' => [0x0046, 0x0242, 'CS', '1'],
        'SourceImageCornealProcessedDataSequence' => [0x0046, 0x0244, 'SQ', '1'],
        'CornealPointLocation' => [0x0046, 0x0247, 'FL', '3'],
        'CornealPointEstimated' => [0x0046, 0x0248, 'CS', '1'],
        'AxialPower' => [0x0046, 0x0249, 'FL', '1'],
        'TangentialPower' => [0x0046, 0x0250, 'FL', '1'],
        'RefractivePower' => [0x0046, 0x0251, 'FL', '1'],
        'RelativeElevation' => [0x0046, 0x0252, 'FL', '1'],
        'CornealWavefront' => [0x0046, 0x0253, 'FL', '1'],
        'ImagedVolumeWidth' => [0x0048, 0x0001, 'FL', '1'],
        'ImagedVolumeHeight' => [0x0048, 0x0002, 'FL', '1'],
        'ImagedVolumeDepth' => [0x0048, 0x0003, 'FL', '1'],
        'TotalPixelMatrixColumns' => [0x0048, 0x0006, 'UL', '1'],
        'TotalPixelMatrixRows' => [0x0048, 0x0007, 'UL', '1'],
        'TotalPixelMatrixOriginSequence' => [0x0048, 0x0008, 'SQ', '1'],
        'SpecimenLabelInImage' => [0x0048, 0x0010, 'CS', '1'],
        'FocusMethod' => [0x0048, 0x0011, 'CS', '1'],
        'ExtendedDepthOfField' => [0x0048, 0x0012, 'CS', '1'],
        'NumberOfFocalPlanes' => [0x0048, 0x0013, 'US', '1'],
        'DistanceBetweenFocalPlanes' => [0x0048, 0x0014, 'FL', '1'],
        'RecommendedAbsentPixelCIELabValue' => [0x0048, 0x0015, 'US', '3'],
        'IlluminatorTypeCodeSequence' => [0x0048, 0x0100, 'SQ', '1'],
        'ImageOrientationSlide' => [0x0048, 0x0102, 'DS', '6'],
        'OpticalPathSequence' => [0x0048, 0x0105, 'SQ', '1'],
        'OpticalPathIdentifier' => [0x0048, 0x0106, 'SH', '1'],
        'OpticalPathDescription' => [0x0048, 0x0107, 'ST', '1'],
        'IlluminationColorCodeSequence' => [0x0048, 0x0108, 'SQ', '1'],
        'SpecimenReferenceSequence' => [0x0048, 0x0110, 'SQ', '1'],
        'CondenserLensPower' => [0x0048, 0x0111, 'DS', '1'],
        'ObjectiveLensPower' => [0x0048, 0x0112, 'DS', '1'],
        'ObjectiveLensNumericalAperture' => [0x0048, 0x0113, 'DS', '1'],
        'ConfocalMode' => [0x0048, 0x0114, 'CS', '1'],
        'TissueLocation' => [0x0048, 0x0115, 'CS', '1'],
        'ConfocalMicroscopyImageFrameTypeSequence' => [0x0048, 0x0116, 'SQ', '1'],
        'ImageAcquisitionDepth' => [0x0048, 0x0117, 'FD', '1'],
        'PaletteColorLookupTableSequence' => [0x0048, 0x0120, 'SQ', '1'],
        'OpticalPathIdentificationSequence' => [0x0048, 0x0207, 'SQ', '1'],
        'PlanePositionSlideSequence' => [0x0048, 0x021a, 'SQ', '1'],
        'ColumnPositionInTotalImagePixelMatrix' => [0x0048, 0x021e, 'SL', '1'],
        'RowPositionInTotalImagePixelMatrix' => [0x0048, 0x021f, 'SL', '1'],
        'PixelOriginInterpretation' => [0x0048, 0x0301, 'CS', '1'],
        'NumberOfOpticalPaths' => [0x0048, 0x0302, 'UL', '1'],
        'TotalPixelMatrixFocalPlanes' => [0x0048, 0x0303, 'UL', '1'],
        'TilesOverlap' => [0x0048, 0x0304, 'CS', '1'],
        'CalibrationImage' => [0x0050, 0x0004, 'CS', '1'],
        'DeviceSequence' => [0x0050, 0x0010, 'SQ', '1'],
        'ContainerComponentTypeCodeSequence' => [0x0050, 0x0012, 'SQ', '1'],
        'ContainerComponentThickness' => [0x0050, 0x0013, 'FD', '1'],
        'DeviceLength' => [0x0050, 0x0014, 'DS', '1'],
        'ContainerComponentWidth' => [0x0050, 0x0015, 'FD', '1'],
        'DeviceDiameter' => [0x0050, 0x0016, 'DS', '1'],
        'DeviceDiameterUnits' => [0x0050, 0x0017, 'CS', '1'],
        'DeviceVolume' => [0x0050, 0x0018, 'DS', '1'],
        'InterMarkerDistance' => [0x0050, 0x0019, 'DS', '1'],
        'ContainerComponentMaterial' => [0x0050, 0x001a, 'CS', '1'],
        'ContainerComponentID' => [0x0050, 0x001b, 'LO', '1'],
        'ContainerComponentLength' => [0x0050, 0x001c, 'FD', '1'],
        'ContainerComponentDiameter' => [0x0050, 0x001d, 'FD', '1'],
        'ContainerComponentDescription' => [0x0050, 0x001e, 'LO', '1'],
        'DeviceDescription' => [0x0050, 0x0020, 'LO', '1'],
        'LongDeviceDescription' => [0x0050, 0x0021, 'ST', '1'],
        'ContrastBolusIngredientPercentByVolume' => [0x0052, 0x0001, 'FL', '1'],
        'OCTFocalDistance' => [0x0052, 0x0002, 'FD', '1'],
        'BeamSpotSize' => [0x0052, 0x0003, 'FD', '1'],
        'EffectiveRefractiveIndex' => [0x0052, 0x0004, 'FD', '1'],
        'OCTAcquisitionDomain' => [0x0052, 0x0006, 'CS', '1'],
        'OCTOpticalCenterWavelength' => [0x0052, 0x0007, 'FD', '1'],
        'AxialResolution' => [0x0052, 0x0008, 'FD', '1'],
        'RangingDepth' => [0x0052, 0x0009, 'FD', '1'],
        'ALineRate' => [0x0052, 0x0011, 'FD', '1'],
        'ALinesPerFrame' => [0x0052, 0x0012, 'US', '1'],
        'CatheterRotationalRate' => [0x0052, 0x0013, 'FD', '1'],
        'ALinePixelSpacing' => [0x0052, 0x0014, 'FD', '1'],
        'ModeOfPercutaneousAccessSequence' => [0x0052, 0x0016, 'SQ', '1'],
        'IntravascularOCTFrameTypeSequence' => [0x0052, 0x0025, 'SQ', '1'],
        'OCTZOffsetApplied' => [0x0052, 0x0026, 'CS', '1'],
        'IntravascularFrameContentSequence' => [0x0052, 0x0027, 'SQ', '1'],
        'IntravascularLongitudinalDistance' => [0x0052, 0x0028, 'FD', '1'],
        'IntravascularOCTFrameContentSequence' => [0x0052, 0x0029, 'SQ', '1'],
        'OCTZOffsetCorrection' => [0x0052, 0x0030, 'SS', '1'],
        'CatheterDirectionOfRotation' => [0x0052, 0x0031, 'CS', '1'],
        'SeamLineLocation' => [0x0052, 0x0033, 'FD', '1'],
        'FirstALineLocation' => [0x0052, 0x0034, 'FD', '1'],
        'SeamLineIndex' => [0x0052, 0x0036, 'US', '1'],
        'NumberOfPaddedALines' => [0x0052, 0x0038, 'US', '1'],
        'InterpolationType' => [0x0052, 0x0039, 'CS', '1'],
        'RefractiveIndexApplied' => [0x0052, 0x003a, 'CS', '1'],
        'EnergyWindowVector' => [0x0054, 0x0010, 'US', '1-n'],
        'NumberOfEnergyWindows' => [0x0054, 0x0011, 'US', '1'],
        'EnergyWindowInformationSequence' => [0x0054, 0x0012, 'SQ', '1'],
        'EnergyWindowRangeSequence' => [0x0054, 0x0013, 'SQ', '1'],
        'EnergyWindowLowerLimit' => [0x0054, 0x0014, 'DS', '1'],
        'EnergyWindowUpperLimit' => [0x0054, 0x0015, 'DS', '1'],
        'RadiopharmaceuticalInformationSequence' => [0x0054, 0x0016, 'SQ', '1'],
        'ResidualSyringeCounts' => [0x0054, 0x0017, 'IS', '1'],
        'EnergyWindowName' => [0x0054, 0x0018, 'SH', '1'],
        'DetectorVector' => [0x0054, 0x0020, 'US', '1-n'],
        'NumberOfDetectors' => [0x0054, 0x0021, 'US', '1'],
        'DetectorInformationSequence' => [0x0054, 0x0022, 'SQ', '1'],
        'PhaseVector' => [0x0054, 0x0030, 'US', '1-n'],
        'NumberOfPhases' => [0x0054, 0x0031, 'US', '1'],
        'PhaseInformationSequence' => [0x0054, 0x0032, 'SQ', '1'],
        'NumberOfFramesInPhase' => [0x0054, 0x0033, 'US', '1'],
        'PhaseDelay' => [0x0054, 0x0036, 'IS', '1'],
        'PauseBetweenFrames' => [0x0054, 0x0038, 'IS', '1'],
        'PhaseDescription' => [0x0054, 0x0039, 'CS', '1'],
        'RotationVector' => [0x0054, 0x0050, 'US', '1-n'],
        'NumberOfRotations' => [0x0054, 0x0051, 'US', '1'],
        'RotationInformationSequence' => [0x0054, 0x0052, 'SQ', '1'],
        'NumberOfFramesInRotation' => [0x0054, 0x0053, 'US', '1'],
        'RRIntervalVector' => [0x0054, 0x0060, 'US', '1-n'],
        'NumberOfRRIntervals' => [0x0054, 0x0061, 'US', '1'],
        'GatedInformationSequence' => [0x0054, 0x0062, 'SQ', '1'],
        'DataInformationSequence' => [0x0054, 0x0063, 'SQ', '1'],
        'TimeSlotVector' => [0x0054, 0x0070, 'US', '1-n'],
        'NumberOfTimeSlots' => [0x0054, 0x0071, 'US', '1'],
        'TimeSlotInformationSequence' => [0x0054, 0x0072, 'SQ', '1'],
        'TimeSlotTime' => [0x0054, 0x0073, 'DS', '1'],
        'SliceVector' => [0x0054, 0x0080, 'US', '1-n'],
        'NumberOfSlices' => [0x0054, 0x0081, 'US', '1'],
        'AngularViewVector' => [0x0054, 0x0090, 'US', '1-n'],
        'TimeSliceVector' => [0x0054, 0x0100, 'US', '1-n'],
        'NumberOfTimeSlices' => [0x0054, 0x0101, 'US', '1'],
        'StartAngle' => [0x0054, 0x0200, 'DS', '1'],
        'TypeOfDetectorMotion' => [0x0054, 0x0202, 'CS', '1'],
        'TriggerVector' => [0x0054, 0x0210, 'IS', '1-n'],
        'NumberOfTriggersInPhase' => [0x0054, 0x0211, 'US', '1'],
        'ViewCodeSequence' => [0x0054, 0x0220, 'SQ', '1'],
        'ViewModifierCodeSequence' => [0x0054, 0x0222, 'SQ', '1'],
        'RadionuclideCodeSequence' => [0x0054, 0x0300, 'SQ', '1'],
        'AdministrationRouteCodeSequence' => [0x0054, 0x0302, 'SQ', '1'],
        'RadiopharmaceuticalCodeSequence' => [0x0054, 0x0304, 'SQ', '1'],
        'CalibrationDataSequence' => [0x0054, 0x0306, 'SQ', '1'],
        'EnergyWindowNumber' => [0x0054, 0x0308, 'US', '1'],
        'ImageID' => [0x0054, 0x0400, 'SH', '1'],
        'PatientOrientationCodeSequence' => [0x0054, 0x0410, 'SQ', '1'],
        'PatientOrientationModifierCodeSequence' => [0x0054, 0x0412, 'SQ', '1'],
        'PatientGantryRelationshipCodeSequence' => [0x0054, 0x0414, 'SQ', '1'],
        'SliceProgressionDirection' => [0x0054, 0x0500, 'CS', '1'],
        'ScanProgressionDirection' => [0x0054, 0x0501, 'CS', '1'],
        'SeriesType' => [0x0054, 0x1000, 'CS', '2'],
        'Units' => [0x0054, 0x1001, 'CS', '1'],
        'CountsSource' => [0x0054, 0x1002, 'CS', '1'],
        'ReprojectionMethod' => [0x0054, 0x1004, 'CS', '1'],
        'SUVType' => [0x0054, 0x1006, 'CS', '1'],
        'RandomsCorrectionMethod' => [0x0054, 0x1100, 'CS', '1'],
        'AttenuationCorrectionMethod' => [0x0054, 0x1101, 'LO', '1'],
        'DecayCorrection' => [0x0054, 0x1102, 'CS', '1'],
        'ReconstructionMethod' => [0x0054, 0x1103, 'LO', '1'],
        'DetectorLinesOfResponseUsed' => [0x0054, 0x1104, 'LO', '1'],
        'ScatterCorrectionMethod' => [0x0054, 0x1105, 'LO', '1'],
        'AxialAcceptance' => [0x0054, 0x1200, 'DS', '1'],
        'AxialMash' => [0x0054, 0x1201, 'IS', '2'],
        'TransverseMash' => [0x0054, 0x1202, 'IS', '1'],
        'DetectorElementSize' => [0x0054, 0x1203, 'DS', '2'],
        'CoincidenceWindowWidth' => [0x0054, 0x1210, 'DS', '1'],
        'SecondaryCountsType' => [0x0054, 0x1220, 'CS', '1-n'],
        'FrameReferenceTime' => [0x0054, 0x1300, 'DS', '1'],
        'PrimaryPromptsCountsAccumulated' => [0x0054, 0x1310, 'IS', '1'],
        'SecondaryCountsAccumulated' => [0x0054, 0x1311, 'IS', '1-n'],
        'SliceSensitivityFactor' => [0x0054, 0x1320, 'DS', '1'],
        'DecayFactor' => [0x0054, 0x1321, 'DS', '1'],
        'DoseCalibrationFactor' => [0x0054, 0x1322, 'DS', '1'],
        'ScatterFractionFactor' => [0x0054, 0x1323, 'DS', '1'],
        'DeadTimeFactor' => [0x0054, 0x1324, 'DS', '1'],
        'ImageIndex' => [0x0054, 0x1330, 'US', '1'],
        'HistogramSequence' => [0x0060, 0x3000, 'SQ', '1'],
        'HistogramNumberOfBins' => [0x0060, 0x3002, 'US', '1'],
        'HistogramFirstBinValue' => [0x0060, 0x3004, 'xs', '1'],
        'HistogramLastBinValue' => [0x0060, 0x3006, 'xs', '1'],
        'HistogramBinWidth' => [0x0060, 0x3008, 'US', '1'],
        'HistogramExplanation' => [0x0060, 0x3010, 'LO', '1'],
        'HistogramData' => [0x0060, 0x3020, 'UL', '1-n'],
        'SegmentationType' => [0x0062, 0x0001, 'CS', '1'],
        'SegmentSequence' => [0x0062, 0x0002, 'SQ', '1'],
        'SegmentedPropertyCategoryCodeSequence' => [0x0062, 0x0003, 'SQ', '1'],
        'SegmentNumber' => [0x0062, 0x0004, 'US', '1'],
        'SegmentLabel' => [0x0062, 0x0005, 'LO', '1'],
        'SegmentDescription' => [0x0062, 0x0006, 'ST', '1'],
        'SegmentationAlgorithmIdentificationSequence' => [0x0062, 0x0007, 'SQ', '1'],
        'SegmentAlgorithmType' => [0x0062, 0x0008, 'CS', '1'],
        'SegmentAlgorithmName' => [0x0062, 0x0009, 'LO', '1-n'],
        'SegmentIdentificationSequence' => [0x0062, 0x000a, 'SQ', '1'],
        'ReferencedSegmentNumber' => [0x0062, 0x000b, 'US', '1-n'],
        'RecommendedDisplayGrayscaleValue' => [0x0062, 0x000c, 'US', '1'],
        'RecommendedDisplayCIELabValue' => [0x0062, 0x000d, 'US', '3'],
        'MaximumFractionalValue' => [0x0062, 0x000e, 'US', '1'],
        'SegmentedPropertyTypeCodeSequence' => [0x0062, 0x000f, 'SQ', '1'],
        'SegmentationFractionalType' => [0x0062, 0x0010, 'CS', '1'],
        'SegmentedPropertyTypeModifierCodeSequence' => [0x0062, 0x0011, 'SQ', '1'],
        'UsedSegmentsSequence' => [0x0062, 0x0012, 'SQ', '1'],
        'SegmentsOverlap' => [0x0062, 0x0013, 'CS', '1'],
        'TrackingID' => [0x0062, 0x0020, 'UT', '1'],
        'TrackingUID' => [0x0062, 0x0021, 'UI', '1'],
        'DeformableRegistrationSequence' => [0x0064, 0x0002, 'SQ', '1'],
        'SourceFrameOfReferenceUID' => [0x0064, 0x0003, 'UI', '1'],
        'DeformableRegistrationGridSequence' => [0x0064, 0x0005, 'SQ', '1'],
        'GridDimensions' => [0x0064, 0x0007, 'UL', '3'],
        'GridResolution' => [0x0064, 0x0008, 'FD', '3'],
        'VectorGridData' => [0x0064, 0x0009, 'OF', '1'],
        'PreDeformationMatrixRegistrationSequence' => [0x0064, 0x000f, 'SQ', '1'],
        'PostDeformationMatrixRegistrationSequence' => [0x0064, 0x0010, 'SQ', '1'],
        'NumberOfSurfaces' => [0x0066, 0x0001, 'UL', '1'],
        'SurfaceSequence' => [0x0066, 0x0002, 'SQ', '1'],
        'SurfaceNumber' => [0x0066, 0x0003, 'UL', '1'],
        'SurfaceComments' => [0x0066, 0x0004, 'LT', '1'],
        'SurfaceOffset' => [0x0066, 0x0005, 'FL', '1'],
        'SurfaceProcessing' => [0x0066, 0x0009, 'CS', '1'],
        'SurfaceProcessingRatio' => [0x0066, 0x000a, 'FL', '1'],
        'SurfaceProcessingDescription' => [0x0066, 0x000b, 'LO', '1'],
        'RecommendedPresentationOpacity' => [0x0066, 0x000c, 'FL', '1'],
        'RecommendedPresentationType' => [0x0066, 0x000d, 'CS', '1'],
        'FiniteVolume' => [0x0066, 0x000e, 'CS', '1'],
        'Manifold' => [0x0066, 0x0010, 'CS', '1'],
        'SurfacePointsSequence' => [0x0066, 0x0011, 'SQ', '1'],
        'SurfacePointsNormalsSequence' => [0x0066, 0x0012, 'SQ', '1'],
        'SurfaceMeshPrimitivesSequence' => [0x0066, 0x0013, 'SQ', '1'],
        'NumberOfSurfacePoints' => [0x0066, 0x0015, 'UL', '1'],
        'PointCoordinatesData' => [0x0066, 0x0016, 'OF', '1'],
        'PointPositionAccuracy' => [0x0066, 0x0017, 'FL', '3'],
        'MeanPointDistance' => [0x0066, 0x0018, 'FL', '1'],
        'MaximumPointDistance' => [0x0066, 0x0019, 'FL', '1'],
        'PointsBoundingBoxCoordinates' => [0x0066, 0x001a, 'FL', '6'],
        'AxisOfRotation' => [0x0066, 0x001b, 'FL', '3'],
        'CenterOfRotation' => [0x0066, 0x001c, 'FL', '3'],
        'NumberOfVectors' => [0x0066, 0x001e, 'UL', '1'],
        'VectorDimensionality' => [0x0066, 0x001f, 'US', '1'],
        'VectorAccuracy' => [0x0066, 0x0020, 'FL', '1-n'],
        'VectorCoordinateData' => [0x0066, 0x0021, 'OF', '1'],
        'DoublePointCoordinatesData' => [0x0066, 0x0022, 'OD', '1'],
        'TriangleStripSequence' => [0x0066, 0x0026, 'SQ', '1'],
        'TriangleFanSequence' => [0x0066, 0x0027, 'SQ', '1'],
        'LineSequence' => [0x0066, 0x0028, 'SQ', '1'],
        'SurfaceCount' => [0x0066, 0x002a, 'UL', '1'],
        'ReferencedSurfaceSequence' => [0x0066, 0x002b, 'SQ', '1'],
        'ReferencedSurfaceNumber' => [0x0066, 0x002c, 'UL', '1'],
        'SegmentSurfaceGenerationAlgorithmIdentificationSequence' => [0x0066, 0x002d, 'SQ', '1'],
        'SegmentSurfaceSourceInstanceSequence' => [0x0066, 0x002e, 'SQ', '1'],
        'AlgorithmFamilyCodeSequence' => [0x0066, 0x002f, 'SQ', '1'],
        'AlgorithmNameCodeSequence' => [0x0066, 0x0030, 'SQ', '1'],
        'AlgorithmVersion' => [0x0066, 0x0031, 'LO', '1'],
        'AlgorithmParameters' => [0x0066, 0x0032, 'LT', '1'],
        'FacetSequence' => [0x0066, 0x0034, 'SQ', '1'],
        'SurfaceProcessingAlgorithmIdentificationSequence' => [0x0066, 0x0035, 'SQ', '1'],
        'AlgorithmName' => [0x0066, 0x0036, 'LO', '1'],
        'RecommendedPointRadius' => [0x0066, 0x0037, 'FL', '1'],
        'RecommendedLineThickness' => [0x0066, 0x0038, 'FL', '1'],
        'LongPrimitivePointIndexList' => [0x0066, 0x0040, 'OL', '1'],
        'LongTrianglePointIndexList' => [0x0066, 0x0041, 'OL', '1'],
        'LongEdgePointIndexList' => [0x0066, 0x0042, 'OL', '1'],
        'LongVertexPointIndexList' => [0x0066, 0x0043, 'OL', '1'],
        'TrackSetSequence' => [0x0066, 0x0101, 'SQ', '1'],
        'TrackSequence' => [0x0066, 0x0102, 'SQ', '1'],
        'RecommendedDisplayCIELabValueList' => [0x0066, 0x0103, 'OW', '1'],
        'TrackingAlgorithmIdentificationSequence' => [0x0066, 0x0104, 'SQ', '1'],
        'TrackSetNumber' => [0x0066, 0x0105, 'UL', '1'],
        'TrackSetLabel' => [0x0066, 0x0106, 'LO', '1'],
        'TrackSetDescription' => [0x0066, 0x0107, 'UT', '1'],
        'TrackSetAnatomicalTypeCodeSequence' => [0x0066, 0x0108, 'SQ', '1'],
        'MeasurementsSequence' => [0x0066, 0x0121, 'SQ', '1'],
        'TrackSetStatisticsSequence' => [0x0066, 0x0124, 'SQ', '1'],
        'FloatingPointValues' => [0x0066, 0x0125, 'OF', '1'],
        'TrackPointIndexList' => [0x0066, 0x0129, 'OL', '1'],
        'TrackStatisticsSequence' => [0x0066, 0x0130, 'SQ', '1'],
        'MeasurementValuesSequence' => [0x0066, 0x0132, 'SQ', '1'],
        'DiffusionAcquisitionCodeSequence' => [0x0066, 0x0133, 'SQ', '1'],
        'DiffusionModelCodeSequence' => [0x0066, 0x0134, 'SQ', '1'],
        'ImplantSize' => [0x0068, 0x6210, 'LO', '1'],
        'ImplantTemplateVersion' => [0x0068, 0x6221, 'LO', '1'],
        'ReplacedImplantTemplateSequence' => [0x0068, 0x6222, 'SQ', '1'],
        'ImplantType' => [0x0068, 0x6223, 'CS', '1'],
        'DerivationImplantTemplateSequence' => [0x0068, 0x6224, 'SQ', '1'],
        'OriginalImplantTemplateSequence' => [0x0068, 0x6225, 'SQ', '1'],
        'EffectiveDateTime' => [0x0068, 0x6226, 'DT', '1'],
        'ImplantTargetAnatomySequence' => [0x0068, 0x6230, 'SQ', '1'],
        'InformationFromManufacturerSequence' => [0x0068, 0x6260, 'SQ', '1'],
        'NotificationFromManufacturerSequence' => [0x0068, 0x6265, 'SQ', '1'],
        'InformationIssueDateTime' => [0x0068, 0x6270, 'DT', '1'],
        'InformationSummary' => [0x0068, 0x6280, 'ST', '1'],
        'ImplantRegulatoryDisapprovalCodeSequence' => [0x0068, 0x62a0, 'SQ', '1'],
        'OverallTemplateSpatialTolerance' => [0x0068, 0x62a5, 'FD', '1'],
        'HPGLDocumentSequence' => [0x0068, 0x62c0, 'SQ', '1'],
        'HPGLDocumentID' => [0x0068, 0x62d0, 'US', '1'],
        'HPGLDocumentLabel' => [0x0068, 0x62d5, 'LO', '1'],
        'ViewOrientationCodeSequence' => [0x0068, 0x62e0, 'SQ', '1'],
        'ViewOrientationModifierCodeSequence' => [0x0068, 0x62f0, 'SQ', '1'],
        'HPGLDocumentScaling' => [0x0068, 0x62f2, 'FD', '1'],
        'HPGLDocument' => [0x0068, 0x6300, 'OB', '1'],
        'HPGLContourPenNumber' => [0x0068, 0x6310, 'US', '1'],
        'HPGLPenSequence' => [0x0068, 0x6320, 'SQ', '1'],
        'HPGLPenNumber' => [0x0068, 0x6330, 'US', '1'],
        'HPGLPenLabel' => [0x0068, 0x6340, 'LO', '1'],
        'HPGLPenDescription' => [0x0068, 0x6345, 'ST', '1'],
        'RecommendedRotationPoint' => [0x0068, 0x6346, 'FD', '2'],
        'BoundingRectangle' => [0x0068, 0x6347, 'FD', '4'],
        'ImplantTemplate3DModelSurfaceNumber' => [0x0068, 0x6350, 'US', '1-n'],
        'SurfaceModelDescriptionSequence' => [0x0068, 0x6360, 'SQ', '1'],
        'SurfaceModelLabel' => [0x0068, 0x6380, 'LO', '1'],
        'SurfaceModelScalingFactor' => [0x0068, 0x6390, 'FD', '1'],
        'MaterialsCodeSequence' => [0x0068, 0x63a0, 'SQ', '1'],
        'CoatingMaterialsCodeSequence' => [0x0068, 0x63a4, 'SQ', '1'],
        'ImplantTypeCodeSequence' => [0x0068, 0x63a8, 'SQ', '1'],
        'FixationMethodCodeSequence' => [0x0068, 0x63ac, 'SQ', '1'],
        'MatingFeatureSetsSequence' => [0x0068, 0x63b0, 'SQ', '1'],
        'MatingFeatureSetID' => [0x0068, 0x63c0, 'US', '1'],
        'MatingFeatureSetLabel' => [0x0068, 0x63d0, 'LO', '1'],
        'MatingFeatureSequence' => [0x0068, 0x63e0, 'SQ', '1'],
        'MatingFeatureID' => [0x0068, 0x63f0, 'US', '1'],
        'MatingFeatureDegreeOfFreedomSequence' => [0x0068, 0x6400, 'SQ', '1'],
        'DegreeOfFreedomID' => [0x0068, 0x6410, 'US', '1'],
        'DegreeOfFreedomType' => [0x0068, 0x6420, 'CS', '1'],
        'TwoDMatingFeatureCoordinatesSequence' => [0x0068, 0x6430, 'SQ', '1'],
        'ReferencedHPGLDocumentID' => [0x0068, 0x6440, 'US', '1'],
        'TwoDMatingPoint' => [0x0068, 0x6450, 'FD', '2'],
        'TwoDMatingAxes' => [0x0068, 0x6460, 'FD', '4'],
        'TwoDDegreeOfFreedomSequence' => [0x0068, 0x6470, 'SQ', '1'],
        'ThreeDDegreeOfFreedomAxis' => [0x0068, 0x6490, 'FD', '3'],
        'RangeOfFreedom' => [0x0068, 0x64a0, 'FD', '2'],
        'ThreeDMatingPoint' => [0x0068, 0x64c0, 'FD', '3'],
        'ThreeDMatingAxes' => [0x0068, 0x64d0, 'FD', '9'],
        'TwoDDegreeOfFreedomAxis' => [0x0068, 0x64f0, 'FD', '3'],
        'PlanningLandmarkPointSequence' => [0x0068, 0x6500, 'SQ', '1'],
        'PlanningLandmarkLineSequence' => [0x0068, 0x6510, 'SQ', '1'],
        'PlanningLandmarkPlaneSequence' => [0x0068, 0x6520, 'SQ', '1'],
        'PlanningLandmarkID' => [0x0068, 0x6530, 'US', '1'],
        'PlanningLandmarkDescription' => [0x0068, 0x6540, 'LO', '1'],
        'PlanningLandmarkIdentificationCodeSequence' => [0x0068, 0x6545, 'SQ', '1'],
        'TwoDPointCoordinatesSequence' => [0x0068, 0x6550, 'SQ', '1'],
        'TwoDPointCoordinates' => [0x0068, 0x6560, 'FD', '2'],
        'ThreeDPointCoordinates' => [0x0068, 0x6590, 'FD', '3'],
        'TwoDLineCoordinatesSequence' => [0x0068, 0x65a0, 'SQ', '1'],
        'TwoDLineCoordinates' => [0x0068, 0x65b0, 'FD', '4'],
        'ThreeDLineCoordinates' => [0x0068, 0x65d0, 'FD', '6'],
        'TwoDPlaneCoordinatesSequence' => [0x0068, 0x65e0, 'SQ', '1'],
        'TwoDPlaneIntersection' => [0x0068, 0x65f0, 'FD', '4'],
        'ThreeDPlaneOrigin' => [0x0068, 0x6610, 'FD', '3'],
        'ThreeDPlaneNormal' => [0x0068, 0x6620, 'FD', '3'],
        'ModelModification' => [0x0068, 0x7001, 'CS', '1'],
        'ModelMirroring' => [0x0068, 0x7002, 'CS', '1'],
        'ModelUsageCodeSequence' => [0x0068, 0x7003, 'SQ', '1'],
        'ModelGroupUID' => [0x0068, 0x7004, 'UI', '1'],
        'RelativeURIReferenceWithinEncapsulatedDocument' => [0x0068, 0x7005, 'UR', '1'],
        'AnnotationCoordinateType' => [0x006a, 0x0001, 'CS', '1'],
        'AnnotationGroupSequence' => [0x006a, 0x0002, 'SQ', '1'],
        'AnnotationGroupUID' => [0x006a, 0x0003, 'UI', '1'],
        'AnnotationGroupLabel' => [0x006a, 0x0005, 'LO', '1'],
        'AnnotationGroupDescription' => [0x006a, 0x0006, 'UT', '1'],
        'AnnotationGroupGenerationType' => [0x006a, 0x0007, 'CS', '1'],
        'AnnotationGroupAlgorithmIdentificationSequence' => [0x006a, 0x0008, 'SQ', '1'],
        'AnnotationPropertyCategoryCodeSequence' => [0x006a, 0x0009, 'SQ', '1'],
        'AnnotationPropertyTypeCodeSequence' => [0x006a, 0x000a, 'SQ', '1'],
        'AnnotationPropertyTypeModifierCodeSequence' => [0x006a, 0x000b, 'SQ', '1'],
        'NumberOfAnnotations' => [0x006a, 0x000c, 'UL', '1'],
        'AnnotationAppliesToAllOpticalPaths' => [0x006a, 0x000d, 'CS', '1'],
        'ReferencedOpticalPathIdentifier' => [0x006a, 0x000e, 'SH', '1-n'],
        'AnnotationAppliesToAllZPlanes' => [0x006a, 0x000f, 'CS', '1'],
        'CommonZCoordinateValue' => [0x006a, 0x0010, 'FD', '1-n'],
        'AnnotationIndexList' => [0x006a, 0x0011, 'OL', '1'],
        'GraphicAnnotationSequence' => [0x0070, 0x0001, 'SQ', '1'],
        'GraphicLayer' => [0x0070, 0x0002, 'CS', '1'],
        'BoundingBoxAnnotationUnits' => [0x0070, 0x0003, 'CS', '1'],
        'AnchorPointAnnotationUnits' => [0x0070, 0x0004, 'CS', '1'],
        'GraphicAnnotationUnits' => [0x0070, 0x0005, 'CS', '1'],
        'UnformattedTextValue' => [0x0070, 0x0006, 'ST', '1'],
        'TextObjectSequence' => [0x0070, 0x0008, 'SQ', '1'],
        'GraphicObjectSequence' => [0x0070, 0x0009, 'SQ', '1'],
        'BoundingBoxTopLeftHandCorner' => [0x0070, 0x0010, 'FL', '2'],
        'BoundingBoxBottomRightHandCorner' => [0x0070, 0x0011, 'FL', '2'],
        'BoundingBoxTextHorizontalJustification' => [0x0070, 0x0012, 'CS', '1'],
        'AnchorPoint' => [0x0070, 0x0014, 'FL', '2'],
        'AnchorPointVisibility' => [0x0070, 0x0015, 'CS', '1'],
        'GraphicDimensions' => [0x0070, 0x0020, 'US', '1'],
        'NumberOfGraphicPoints' => [0x0070, 0x0021, 'US', '1'],
        'GraphicData' => [0x0070, 0x0022, 'FL', '2-n'],
        'GraphicType' => [0x0070, 0x0023, 'CS', '1'],
        'GraphicFilled' => [0x0070, 0x0024, 'CS', '1'],
        'ImageHorizontalFlip' => [0x0070, 0x0041, 'CS', '1'],
        'ImageRotation' => [0x0070, 0x0042, 'US', '1'],
        'DisplayedAreaTopLeftHandCorner' => [0x0070, 0x0052, 'SL', '2'],
        'DisplayedAreaBottomRightHandCorner' => [0x0070, 0x0053, 'SL', '2'],
        'DisplayedAreaSelectionSequence' => [0x0070, 0x005a, 'SQ', '1'],
        'GraphicLayerSequence' => [0x0070, 0x0060, 'SQ', '1'],
        'GraphicLayerOrder' => [0x0070, 0x0062, 'IS', '1'],
        'GraphicLayerRecommendedDisplayGrayscaleValue' => [0x0070, 0x0066, 'US', '1'],
        'GraphicLayerDescription' => [0x0070, 0x0068, 'LO', '1'],
        'ContentLabel' => [0x0070, 0x0080, 'CS', '1'],
        'ContentDescription' => [0x0070, 0x0081, 'LO', '1'],
        'PresentationCreationDate' => [0x0070, 0x0082, 'DA', '1'],
        'PresentationCreationTime' => [0x0070, 0x0083, 'TM', '1'],
        'ContentCreatorName' => [0x0070, 0x0084, 'PN', '1'],
        'ContentCreatorIdentificationCodeSequence' => [0x0070, 0x0086, 'SQ', '1'],
        'AlternateContentDescriptionSequence' => [0x0070, 0x0087, 'SQ', '1'],
        'PresentationSizeMode' => [0x0070, 0x0100, 'CS', '1'],
        'PresentationPixelSpacing' => [0x0070, 0x0101, 'DS', '2'],
        'PresentationPixelAspectRatio' => [0x0070, 0x0102, 'IS', '2'],
        'PresentationPixelMagnificationRatio' => [0x0070, 0x0103, 'FL', '1'],
        'GraphicGroupLabel' => [0x0070, 0x0207, 'LO', '1'],
        'GraphicGroupDescription' => [0x0070, 0x0208, 'ST', '1'],
        'CompoundGraphicSequence' => [0x0070, 0x0209, 'SQ', '1'],
        'CompoundGraphicInstanceID' => [0x0070, 0x0226, 'UL', '1'],
        'FontName' => [0x0070, 0x0227, 'LO', '1'],
        'FontNameType' => [0x0070, 0x0228, 'CS', '1'],
        'CSSFontName' => [0x0070, 0x0229, 'LO', '1'],
        'RotationAngle' => [0x0070, 0x0230, 'FD', '1'],
        'TextStyleSequence' => [0x0070, 0x0231, 'SQ', '1'],
        'LineStyleSequence' => [0x0070, 0x0232, 'SQ', '1'],
        'FillStyleSequence' => [0x0070, 0x0233, 'SQ', '1'],
        'GraphicGroupSequence' => [0x0070, 0x0234, 'SQ', '1'],
        'TextColorCIELabValue' => [0x0070, 0x0241, 'US', '3'],
        'HorizontalAlignment' => [0x0070, 0x0242, 'CS', '1'],
        'VerticalAlignment' => [0x0070, 0x0243, 'CS', '1'],
        'ShadowStyle' => [0x0070, 0x0244, 'CS', '1'],
        'ShadowOffsetX' => [0x0070, 0x0245, 'FL', '1'],
        'ShadowOffsetY' => [0x0070, 0x0246, 'FL', '1'],
        'ShadowColorCIELabValue' => [0x0070, 0x0247, 'US', '3'],
        'Underlined' => [0x0070, 0x0248, 'CS', '1'],
        'Bold' => [0x0070, 0x0249, 'CS', '1'],
        'Italic' => [0x0070, 0x0250, 'CS', '1'],
        'PatternOnColorCIELabValue' => [0x0070, 0x0251, 'US', '3'],
        'PatternOffColorCIELabValue' => [0x0070, 0x0252, 'US', '3'],
        'LineThickness' => [0x0070, 0x0253, 'FL', '1'],
        'LineDashingStyle' => [0x0070, 0x0254, 'CS', '1'],
        'LinePattern' => [0x0070, 0x0255, 'UL', '1'],
        'FillPattern' => [0x0070, 0x0256, 'OB', '1'],
        'FillMode' => [0x0070, 0x0257, 'CS', '1'],
        'ShadowOpacity' => [0x0070, 0x0258, 'FL', '1'],
        'GapLength' => [0x0070, 0x0261, 'FL', '1'],
        'DiameterOfVisibility' => [0x0070, 0x0262, 'FL', '1'],
        'RotationPoint' => [0x0070, 0x0273, 'FL', '2'],
        'TickAlignment' => [0x0070, 0x0274, 'CS', '1'],
        'ShowTickLabel' => [0x0070, 0x0278, 'CS', '1'],
        'TickLabelAlignment' => [0x0070, 0x0279, 'CS', '1'],
        'CompoundGraphicUnits' => [0x0070, 0x0282, 'CS', '1'],
        'PatternOnOpacity' => [0x0070, 0x0284, 'FL', '1'],
        'PatternOffOpacity' => [0x0070, 0x0285, 'FL', '1'],
        'MajorTicksSequence' => [0x0070, 0x0287, 'SQ', '1'],
        'TickPosition' => [0x0070, 0x0288, 'FL', '1'],
        'TickLabel' => [0x0070, 0x0289, 'SH', '1'],
        'CompoundGraphicType' => [0x0070, 0x0294, 'CS', '1'],
        'GraphicGroupID' => [0x0070, 0x0295, 'UL', '1'],
        'ShapeType' => [0x0070, 0x0306, 'CS', '1'],
        'RegistrationSequence' => [0x0070, 0x0308, 'SQ', '1'],
        'MatrixRegistrationSequence' => [0x0070, 0x0309, 'SQ', '1'],
        'MatrixSequence' => [0x0070, 0x030a, 'SQ', '1'],
        'FrameOfReferenceToDisplayedCoordinateSystemTransformationMatrix' => [0x0070, 0x030b, 'FD', '16'],
        'FrameOfReferenceTransformationMatrixType' => [0x0070, 0x030c, 'CS', '1'],
        'RegistrationTypeCodeSequence' => [0x0070, 0x030d, 'SQ', '1'],
        'FiducialDescription' => [0x0070, 0x030f, 'ST', '1'],
        'FiducialIdentifier' => [0x0070, 0x0310, 'SH', '1'],
        'FiducialIdentifierCodeSequence' => [0x0070, 0x0311, 'SQ', '1'],
        'ContourUncertaintyRadius' => [0x0070, 0x0312, 'FD', '1'],
        'UsedFiducialsSequence' => [0x0070, 0x0314, 'SQ', '1'],
        'UsedRTStructureSetROISequence' => [0x0070, 0x0315, 'SQ', '1'],
        'GraphicCoordinatesDataSequence' => [0x0070, 0x0318, 'SQ', '1'],
        'FiducialUID' => [0x0070, 0x031a, 'UI', '1'],
        'ReferencedFiducialUID' => [0x0070, 0x031b, 'UI', '1'],
        'FiducialSetSequence' => [0x0070, 0x031c, 'SQ', '1'],
        'FiducialSequence' => [0x0070, 0x031e, 'SQ', '1'],
        'FiducialsPropertyCategoryCodeSequence' => [0x0070, 0x031f, 'SQ', '1'],
        'GraphicLayerRecommendedDisplayCIELabValue' => [0x0070, 0x0401, 'US', '3'],
        'BlendingSequence' => [0x0070, 0x0402, 'SQ', '1'],
        'RelativeOpacity' => [0x0070, 0x0403, 'FL', '1'],
        'ReferencedSpatialRegistrationSequence' => [0x0070, 0x0404, 'SQ', '1'],
        'BlendingPosition' => [0x0070, 0x0405, 'CS', '1'],
        'PresentationDisplayCollectionUID' => [0x0070, 0x1101, 'UI', '1'],
        'PresentationSequenceCollectionUID' => [0x0070, 0x1102, 'UI', '1'],
        'PresentationSequencePositionIndex' => [0x0070, 0x1103, 'US', '1'],
        'RenderedImageReferenceSequence' => [0x0070, 0x1104, 'SQ', '1'],
        'VolumetricPresentationStateInputSequence' => [0x0070, 0x1201, 'SQ', '1'],
        'PresentationInputType' => [0x0070, 0x1202, 'CS', '1'],
        'InputSequencePositionIndex' => [0x0070, 0x1203, 'US', '1'],
        'Crop' => [0x0070, 0x1204, 'CS', '1'],
        'CroppingSpecificationIndex' => [0x0070, 0x1205, 'US', '1-n'],
        'VolumetricPresentationInputNumber' => [0x0070, 0x1207, 'US', '1'],
        'ImageVolumeGeometry' => [0x0070, 0x1208, 'CS', '1'],
        'VolumetricPresentationInputSetUID' => [0x0070, 0x1209, 'UI', '1'],
        'VolumetricPresentationInputSetSequence' => [0x0070, 0x120a, 'SQ', '1'],
        'GlobalCrop' => [0x0070, 0x120b, 'CS', '1'],
        'GlobalCroppingSpecificationIndex' => [0x0070, 0x120c, 'US', '1-n'],
        'RenderingMethod' => [0x0070, 0x120d, 'CS', '1'],
        'VolumeCroppingSequence' => [0x0070, 0x1301, 'SQ', '1'],
        'VolumeCroppingMethod' => [0x0070, 0x1302, 'CS', '1'],
        'BoundingBoxCrop' => [0x0070, 0x1303, 'FD', '6'],
        'ObliqueCroppingPlaneSequence' => [0x0070, 0x1304, 'SQ', '1'],
        'Plane' => [0x0070, 0x1305, 'FD', '4'],
        'PlaneNormal' => [0x0070, 0x1306, 'FD', '3'],
        'CroppingSpecificationNumber' => [0x0070, 0x1309, 'US', '1'],
        'MultiPlanarReconstructionStyle' => [0x0070, 0x1501, 'CS', '1'],
        'MPRThicknessType' => [0x0070, 0x1502, 'CS', '1'],
        'MPRSlabThickness' => [0x0070, 0x1503, 'FD', '1'],
        'MPRTopLeftHandCorner' => [0x0070, 0x1505, 'FD', '3'],
        'MPRViewWidthDirection' => [0x0070, 0x1507, 'FD', '3'],
        'MPRViewWidth' => [0x0070, 0x1508, 'FD', '1'],
        'NumberOfVolumetricCurvePoints' => [0x0070, 0x150c, 'UL', '1'],
        'VolumetricCurvePoints' => [0x0070, 0x150d, 'OD', '1'],
        'MPRViewHeightDirection' => [0x0070, 0x1511, 'FD', '3'],
        'MPRViewHeight' => [0x0070, 0x1512, 'FD', '1'],
        'RenderProjection' => [0x0070, 0x1602, 'CS', '1'],
        'ViewpointPosition' => [0x0070, 0x1603, 'FD', '3'],
        'ViewpointLookAtPoint' => [0x0070, 0x1604, 'FD', '3'],
        'ViewpointUpDirection' => [0x0070, 0x1605, 'FD', '3'],
        'RenderFieldOfView' => [0x0070, 0x1606, 'FD', '6'],
        'SamplingStepSize' => [0x0070, 0x1607, 'FD', '1'],
        'ShadingStyle' => [0x0070, 0x1701, 'CS', '1'],
        'AmbientReflectionIntensity' => [0x0070, 0x1702, 'FD', '1'],
        'LightDirection' => [0x0070, 0x1703, 'FD', '3'],
        'DiffuseReflectionIntensity' => [0x0070, 0x1704, 'FD', '1'],
        'SpecularReflectionIntensity' => [0x0070, 0x1705, 'FD', '1'],
        'Shininess' => [0x0070, 0x1706, 'FD', '1'],
        'PresentationStateClassificationComponentSequence' => [0x0070, 0x1801, 'SQ', '1'],
        'ComponentType' => [0x0070, 0x1802, 'CS', '1'],
        'ComponentInputSequence' => [0x0070, 0x1803, 'SQ', '1'],
        'VolumetricPresentationInputIndex' => [0x0070, 0x1804, 'US', '1'],
        'PresentationStateCompositorComponentSequence' => [0x0070, 0x1805, 'SQ', '1'],
        'WeightingTransferFunctionSequence' => [0x0070, 0x1806, 'SQ', '1'],
        'VolumetricAnnotationSequence' => [0x0070, 0x1901, 'SQ', '1'],
        'ReferencedStructuredContextSequence' => [0x0070, 0x1903, 'SQ', '1'],
        'ReferencedContentItem' => [0x0070, 0x1904, 'UI', '1'],
        'VolumetricPresentationInputAnnotationSequence' => [0x0070, 0x1905, 'SQ', '1'],
        'AnnotationClipping' => [0x0070, 0x1907, 'CS', '1'],
        'PresentationAnimationStyle' => [0x0070, 0x1a01, 'CS', '1'],
        'RecommendedAnimationRate' => [0x0070, 0x1a03, 'FD', '1'],
        'AnimationCurveSequence' => [0x0070, 0x1a04, 'SQ', '1'],
        'AnimationStepSize' => [0x0070, 0x1a05, 'FD', '1'],
        'SwivelRange' => [0x0070, 0x1a06, 'FD', '1'],
        'VolumetricCurveUpDirections' => [0x0070, 0x1a07, 'OD', '1'],
        'VolumeStreamSequence' => [0x0070, 0x1a08, 'SQ', '1'],
        'RGBATransferFunctionDescription' => [0x0070, 0x1a09, 'LO', '1'],
        'AdvancedBlendingSequence' => [0x0070, 0x1b01, 'SQ', '1'],
        'BlendingInputNumber' => [0x0070, 0x1b02, 'US', '1'],
        'BlendingDisplayInputSequence' => [0x0070, 0x1b03, 'SQ', '1'],
        'BlendingDisplaySequence' => [0x0070, 0x1b04, 'SQ', '1'],
        'BlendingMode' => [0x0070, 0x1b06, 'CS', '1'],
        'TimeSeriesBlending' => [0x0070, 0x1b07, 'CS', '1'],
        'GeometryForDisplay' => [0x0070, 0x1b08, 'CS', '1'],
        'ThresholdSequence' => [0x0070, 0x1b11, 'SQ', '1'],
        'ThresholdValueSequence' => [0x0070, 0x1b12, 'SQ', '1'],
        'ThresholdType' => [0x0070, 0x1b13, 'CS', '1'],
        'ThresholdValue' => [0x0070, 0x1b14, 'FD', '1'],
        'HangingProtocolName' => [0x0072, 0x0002, 'SH', '1'],
        'HangingProtocolDescription' => [0x0072, 0x0004, 'LO', '1'],
        'HangingProtocolLevel' => [0x0072, 0x0006, 'CS', '1'],
        'HangingProtocolCreator' => [0x0072, 0x0008, 'LO', '1'],
        'HangingProtocolCreationDateTime' => [0x0072, 0x000a, 'DT', '1'],
        'HangingProtocolDefinitionSequence' => [0x0072, 0x000c, 'SQ', '1'],
        'HangingProtocolUserIdentificationCodeSequence' => [0x0072, 0x000e, 'SQ', '1'],
        'HangingProtocolUserGroupName' => [0x0072, 0x0010, 'LO', '1'],
        'SourceHangingProtocolSequence' => [0x0072, 0x0012, 'SQ', '1'],
        'NumberOfPriorsReferenced' => [0x0072, 0x0014, 'US', '1'],
        'ImageSetsSequence' => [0x0072, 0x0020, 'SQ', '1'],
        'ImageSetSelectorSequence' => [0x0072, 0x0022, 'SQ', '1'],
        'ImageSetSelectorUsageFlag' => [0x0072, 0x0024, 'CS', '1'],
        'SelectorAttribute' => [0x0072, 0x0026, 'AT', '1'],
        'SelectorValueNumber' => [0x0072, 0x0028, 'US', '1'],
        'TimeBasedImageSetsSequence' => [0x0072, 0x0030, 'SQ', '1'],
        'ImageSetNumber' => [0x0072, 0x0032, 'US', '1'],
        'ImageSetSelectorCategory' => [0x0072, 0x0034, 'CS', '1'],
        'RelativeTime' => [0x0072, 0x0038, 'US', '2'],
        'RelativeTimeUnits' => [0x0072, 0x003a, 'CS', '1'],
        'AbstractPriorValue' => [0x0072, 0x003c, 'SS', '2'],
        'AbstractPriorCodeSequence' => [0x0072, 0x003e, 'SQ', '1'],
        'ImageSetLabel' => [0x0072, 0x0040, 'LO', '1'],
        'SelectorAttributeVR' => [0x0072, 0x0050, 'CS', '1'],
        'SelectorSequencePointer' => [0x0072, 0x0052, 'AT', '1-n'],
        'SelectorSequencePointerPrivateCreator' => [0x0072, 0x0054, 'LO', '1-n'],
        'SelectorAttributePrivateCreator' => [0x0072, 0x0056, 'LO', '1'],
        'SelectorAEValue' => [0x0072, 0x005e, 'AE', '1-n'],
        'SelectorASValue' => [0x0072, 0x005f, 'AS', '1-n'],
        'SelectorATValue' => [0x0072, 0x0060, 'AT', '1-n'],
        'SelectorDAValue' => [0x0072, 0x0061, 'DA', '1-n'],
        'SelectorCSValue' => [0x0072, 0x0062, 'CS', '1-n'],
        'SelectorDTValue' => [0x0072, 0x0063, 'DT', '1-n'],
        'SelectorISValue' => [0x0072, 0x0064, 'IS', '1-n'],
        'SelectorOBValue' => [0x0072, 0x0065, 'OB', '1'],
        'SelectorLOValue' => [0x0072, 0x0066, 'LO', '1-n'],
        'SelectorOFValue' => [0x0072, 0x0067, 'OF', '1'],
        'SelectorLTValue' => [0x0072, 0x0068, 'LT', '1'],
        'SelectorOWValue' => [0x0072, 0x0069, 'OW', '1'],
        'SelectorPNValue' => [0x0072, 0x006a, 'PN', '1-n'],
        'SelectorTMValue' => [0x0072, 0x006b, 'TM', '1-n'],
        'SelectorSHValue' => [0x0072, 0x006c, 'SH', '1-n'],
        'SelectorUNValue' => [0x0072, 0x006d, 'UN', '1'],
        'SelectorSTValue' => [0x0072, 0x006e, 'ST', '1'],
        'SelectorUCValue' => [0x0072, 0x006f, 'UC', '1-n'],
        'SelectorUTValue' => [0x0072, 0x0070, 'UT', '1'],
        'SelectorURValue' => [0x0072, 0x0071, 'UR', '1'],
        'SelectorDSValue' => [0x0072, 0x0072, 'DS', '1-n'],
        'SelectorODValue' => [0x0072, 0x0073, 'OD', '1'],
        'SelectorFDValue' => [0x0072, 0x0074, 'FD', '1-n'],
        'SelectorOLValue' => [0x0072, 0x0075, 'OL', '1'],
        'SelectorFLValue' => [0x0072, 0x0076, 'FL', '1-n'],
        'SelectorULValue' => [0x0072, 0x0078, 'UL', '1-n'],
        'SelectorUSValue' => [0x0072, 0x007a, 'US', '1-n'],
        'SelectorSLValue' => [0x0072, 0x007c, 'SL', '1-n'],
        'SelectorSSValue' => [0x0072, 0x007e, 'SS', '1-n'],
        'SelectorUIValue' => [0x0072, 0x007f, 'UI', '1-n'],
        'SelectorCodeSequenceValue' => [0x0072, 0x0080, 'SQ', '1'],
        'SelectorOVValue' => [0x0072, 0x0081, 'OV', '1'],
        'SelectorSVValue' => [0x0072, 0x0082, 'SV', '1-n'],
        'SelectorUVValue' => [0x0072, 0x0083, 'UV', '1-n'],
        'NumberOfScreens' => [0x0072, 0x0100, 'US', '1'],
        'NominalScreenDefinitionSequence' => [0x0072, 0x0102, 'SQ', '1'],
        'NumberOfVerticalPixels' => [0x0072, 0x0104, 'US', '1'],
        'NumberOfHorizontalPixels' => [0x0072, 0x0106, 'US', '1'],
        'DisplayEnvironmentSpatialPosition' => [0x0072, 0x0108, 'FD', '4'],
        'ScreenMinimumGrayscaleBitDepth' => [0x0072, 0x010a, 'US', '1'],
        'ScreenMinimumColorBitDepth' => [0x0072, 0x010c, 'US', '1'],
        'ApplicationMaximumRepaintTime' => [0x0072, 0x010e, 'US', '1'],
        'DisplaySetsSequence' => [0x0072, 0x0200, 'SQ', '1'],
        'DisplaySetNumber' => [0x0072, 0x0202, 'US', '1'],
        'DisplaySetLabel' => [0x0072, 0x0203, 'LO', '1'],
        'DisplaySetPresentationGroup' => [0x0072, 0x0204, 'US', '1'],
        'DisplaySetPresentationGroupDescription' => [0x0072, 0x0206, 'LO', '1'],
        'PartialDataDisplayHandling' => [0x0072, 0x0208, 'CS', '1'],
        'SynchronizedScrollingSequence' => [0x0072, 0x0210, 'SQ', '1'],
        'DisplaySetScrollingGroup' => [0x0072, 0x0212, 'US', '2-n'],
        'NavigationIndicatorSequence' => [0x0072, 0x0214, 'SQ', '1'],
        'NavigationDisplaySet' => [0x0072, 0x0216, 'US', '1'],
        'ReferenceDisplaySets' => [0x0072, 0x0218, 'US', '1-n'],
        'ImageBoxesSequence' => [0x0072, 0x0300, 'SQ', '1'],
        'ImageBoxNumber' => [0x0072, 0x0302, 'US', '1'],
        'ImageBoxLayoutType' => [0x0072, 0x0304, 'CS', '1'],
        'ImageBoxTileHorizontalDimension' => [0x0072, 0x0306, 'US', '1'],
        'ImageBoxTileVerticalDimension' => [0x0072, 0x0308, 'US', '1'],
        'ImageBoxScrollDirection' => [0x0072, 0x0310, 'CS', '1'],
        'ImageBoxSmallScrollType' => [0x0072, 0x0312, 'CS', '1'],
        'ImageBoxSmallScrollAmount' => [0x0072, 0x0314, 'US', '1'],
        'ImageBoxLargeScrollType' => [0x0072, 0x0316, 'CS', '1'],
        'ImageBoxLargeScrollAmount' => [0x0072, 0x0318, 'US', '1'],
        'ImageBoxOverlapPriority' => [0x0072, 0x0320, 'US', '1'],
        'CineRelativeToRealTime' => [0x0072, 0x0330, 'FD', '1'],
        'FilterOperationsSequence' => [0x0072, 0x0400, 'SQ', '1'],
        'FilterByCategory' => [0x0072, 0x0402, 'CS', '1'],
        'FilterByAttributePresence' => [0x0072, 0x0404, 'CS', '1'],
        'FilterByOperator' => [0x0072, 0x0406, 'CS', '1'],
        'StructuredDisplayBackgroundCIELabValue' => [0x0072, 0x0420, 'US', '3'],
        'EmptyImageBoxCIELabValue' => [0x0072, 0x0421, 'US', '3'],
        'StructuredDisplayImageBoxSequence' => [0x0072, 0x0422, 'SQ', '1'],
        'StructuredDisplayTextBoxSequence' => [0x0072, 0x0424, 'SQ', '1'],
        'ReferencedFirstFrameSequence' => [0x0072, 0x0427, 'SQ', '1'],
        'ImageBoxSynchronizationSequence' => [0x0072, 0x0430, 'SQ', '1'],
        'SynchronizedImageBoxList' => [0x0072, 0x0432, 'US', '2-n'],
        'TypeOfSynchronization' => [0x0072, 0x0434, 'CS', '1'],
        'BlendingOperationType' => [0x0072, 0x0500, 'CS', '1'],
        'ReformattingOperationType' => [0x0072, 0x0510, 'CS', '1'],
        'ReformattingThickness' => [0x0072, 0x0512, 'FD', '1'],
        'ReformattingInterval' => [0x0072, 0x0514, 'FD', '1'],
        'ReformattingOperationInitialViewDirection' => [0x0072, 0x0516, 'CS', '1'],
        'ThreeDRenderingType' => [0x0072, 0x0520, 'CS', '1-n'],
        'SortingOperationsSequence' => [0x0072, 0x0600, 'SQ', '1'],
        'SortByCategory' => [0x0072, 0x0602, 'CS', '1'],
        'SortingDirection' => [0x0072, 0x0604, 'CS', '1'],
        'DisplaySetPatientOrientation' => [0x0072, 0x0700, 'CS', '2'],
        'VOIType' => [0x0072, 0x0702, 'CS', '1'],
        'PseudoColorType' => [0x0072, 0x0704, 'CS', '1'],
        'PseudoColorPaletteInstanceReferenceSequence' => [0x0072, 0x0705, 'SQ', '1'],
        'ShowGrayscaleInverted' => [0x0072, 0x0706, 'CS', '1'],
        'ShowImageTrueSizeFlag' => [0x0072, 0x0710, 'CS', '1'],
        'ShowGraphicAnnotationFlag' => [0x0072, 0x0712, 'CS', '1'],
        'ShowPatientDemographicsFlag' => [0x0072, 0x0714, 'CS', '1'],
        'ShowAcquisitionTechniquesFlag' => [0x0072, 0x0716, 'CS', '1'],
        'DisplaySetHorizontalJustification' => [0x0072, 0x0717, 'CS', '1'],
        'DisplaySetVerticalJustification' => [0x0072, 0x0718, 'CS', '1'],
        'ContinuationStartMeterset' => [0x0074, 0x0120, 'FD', '1'],
        'ContinuationEndMeterset' => [0x0074, 0x0121, 'FD', '1'],
        'ProcedureStepState' => [0x0074, 0x1000, 'CS', '1'],
        'ProcedureStepProgressInformationSequence' => [0x0074, 0x1002, 'SQ', '1'],
        'ProcedureStepProgress' => [0x0074, 0x1004, 'DS', '1'],
        'ProcedureStepProgressDescription' => [0x0074, 0x1006, 'ST', '1'],
        'ProcedureStepProgressParametersSequence' => [0x0074, 0x1007, 'SQ', '1'],
        'ProcedureStepCommunicationsURISequence' => [0x0074, 0x1008, 'SQ', '1'],
        'ContactURI' => [0x0074, 0x100a, 'UR', '1'],
        'ContactDisplayName' => [0x0074, 0x100c, 'LO', '1'],
        'ProcedureStepDiscontinuationReasonCodeSequence' => [0x0074, 0x100e, 'SQ', '1'],
        'BeamTaskSequence' => [0x0074, 0x1020, 'SQ', '1'],
        'BeamTaskType' => [0x0074, 0x1022, 'CS', '1'],
        'AutosequenceFlag' => [0x0074, 0x1025, 'CS', '1'],
        'TableTopVerticalAdjustedPosition' => [0x0074, 0x1026, 'FD', '1'],
        'TableTopLongitudinalAdjustedPosition' => [0x0074, 0x1027, 'FD', '1'],
        'TableTopLateralAdjustedPosition' => [0x0074, 0x1028, 'FD', '1'],
        'PatientSupportAdjustedAngle' => [0x0074, 0x102a, 'FD', '1'],
        'TableTopEccentricAdjustedAngle' => [0x0074, 0x102b, 'FD', '1'],
        'TableTopPitchAdjustedAngle' => [0x0074, 0x102c, 'FD', '1'],
        'TableTopRollAdjustedAngle' => [0x0074, 0x102d, 'FD', '1'],
        'DeliveryVerificationImageSequence' => [0x0074, 0x1030, 'SQ', '1'],
        'VerificationImageTiming' => [0x0074, 0x1032, 'CS', '1'],
        'DoubleExposureFlag' => [0x0074, 0x1034, 'CS', '1'],
        'DoubleExposureOrdering' => [0x0074, 0x1036, 'CS', '1'],
        'RelatedReferenceRTImageSequence' => [0x0074, 0x1040, 'SQ', '1'],
        'GeneralMachineVerificationSequence' => [0x0074, 0x1042, 'SQ', '1'],
        'ConventionalMachineVerificationSequence' => [0x0074, 0x1044, 'SQ', '1'],
        'IonMachineVerificationSequence' => [0x0074, 0x1046, 'SQ', '1'],
        'FailedAttributesSequence' => [0x0074, 0x1048, 'SQ', '1'],
        'OverriddenAttributesSequence' => [0x0074, 0x104a, 'SQ', '1'],
        'ConventionalControlPointVerificationSequence' => [0x0074, 0x104c, 'SQ', '1'],
        'IonControlPointVerificationSequence' => [0x0074, 0x104e, 'SQ', '1'],
        'AttributeOccurrenceSequence' => [0x0074, 0x1050, 'SQ', '1'],
        'AttributeOccurrencePointer' => [0x0074, 0x1052, 'AT', '1'],
        'AttributeItemSelector' => [0x0074, 0x1054, 'UL', '1'],
        'AttributeOccurrencePrivateCreator' => [0x0074, 0x1056, 'LO', '1'],
        'SelectorSequencePointerItems' => [0x0074, 0x1057, 'IS', '1-n'],
        'ScheduledProcedureStepPriority' => [0x0074, 0x1200, 'CS', '1'],
        'WorklistLabel' => [0x0074, 0x1202, 'LO', '1'],
        'ProcedureStepLabel' => [0x0074, 0x1204, 'LO', '1'],
        'ScheduledProcessingParametersSequence' => [0x0074, 0x1210, 'SQ', '1'],
        'PerformedProcessingParametersSequence' => [0x0074, 0x1212, 'SQ', '1'],
        'UnifiedProcedureStepPerformedProcedureSequence' => [0x0074, 0x1216, 'SQ', '1'],
        'ReplacedProcedureStepSequence' => [0x0074, 0x1224, 'SQ', '1'],
        'DeletionLock' => [0x0074, 0x1230, 'LO', '1'],
        'ReceivingAE' => [0x0074, 0x1234, 'AE', '1'],
        'RequestingAE' => [0x0074, 0x1236, 'AE', '1'],
        'ReasonForCancellation' => [0x0074, 0x1238, 'LT', '1'],
        'SCPStatus' => [0x0074, 0x1242, 'CS', '1'],
        'SubscriptionListStatus' => [0x0074, 0x1244, 'CS', '1'],
        'UnifiedProcedureStepListStatus' => [0x0074, 0x1246, 'CS', '1'],
        'BeamOrderIndex' => [0x0074, 0x1324, 'UL', '1'],
        'DoubleExposureMeterset' => [0x0074, 0x1338, 'FD', '1'],
        'DoubleExposureFieldDelta' => [0x0074, 0x133a, 'FD', '4'],
        'BrachyTaskSequence' => [0x0074, 0x1401, 'SQ', '1'],
        'ContinuationStartTotalReferenceAirKerma' => [0x0074, 0x1402, 'DS', '1'],
        'ContinuationEndTotalReferenceAirKerma' => [0x0074, 0x1403, 'DS', '1'],
        'ContinuationPulseNumber' => [0x0074, 0x1404, 'IS', '1'],
        'ChannelDeliveryOrderSequence' => [0x0074, 0x1405, 'SQ', '1'],
        'ReferencedChannelNumber' => [0x0074, 0x1406, 'IS', '1'],
        'StartCumulativeTimeWeight' => [0x0074, 0x1407, 'DS', '1'],
        'EndCumulativeTimeWeight' => [0x0074, 0x1408, 'DS', '1'],
        'OmittedChannelSequence' => [0x0074, 0x1409, 'SQ', '1'],
        'ReasonForChannelOmission' => [0x0074, 0x140a, 'CS', '1'],
        'ReasonForChannelOmissionDescription' => [0x0074, 0x140b, 'LO', '1'],
        'ChannelDeliveryOrderIndex' => [0x0074, 0x140c, 'IS', '1'],
        'ChannelDeliveryContinuationSequence' => [0x0074, 0x140d, 'SQ', '1'],
        'OmittedApplicationSetupSequence' => [0x0074, 0x140e, 'SQ', '1'],
        'ImplantAssemblyTemplateName' => [0x0076, 0x0001, 'LO', '1'],
        'ImplantAssemblyTemplateIssuer' => [0x0076, 0x0003, 'LO', '1'],
        'ImplantAssemblyTemplateVersion' => [0x0076, 0x0006, 'LO', '1'],
        'ReplacedImplantAssemblyTemplateSequence' => [0x0076, 0x0008, 'SQ', '1'],
        'ImplantAssemblyTemplateType' => [0x0076, 0x000a, 'CS', '1'],
        'OriginalImplantAssemblyTemplateSequence' => [0x0076, 0x000c, 'SQ', '1'],
        'DerivationImplantAssemblyTemplateSequence' => [0x0076, 0x000e, 'SQ', '1'],
        'ImplantAssemblyTemplateTargetAnatomySequence' => [0x0076, 0x0010, 'SQ', '1'],
        'ProcedureTypeCodeSequence' => [0x0076, 0x0020, 'SQ', '1'],
        'SurgicalTechnique' => [0x0076, 0x0030, 'LO', '1'],
        'ComponentTypesSequence' => [0x0076, 0x0032, 'SQ', '1'],
        'ComponentTypeCodeSequence' => [0x0076, 0x0034, 'SQ', '1'],
        'ExclusiveComponentType' => [0x0076, 0x0036, 'CS', '1'],
        'MandatoryComponentType' => [0x0076, 0x0038, 'CS', '1'],
        'ComponentSequence' => [0x0076, 0x0040, 'SQ', '1'],
        'ComponentID' => [0x0076, 0x0055, 'US', '1'],
        'ComponentAssemblySequence' => [0x0076, 0x0060, 'SQ', '1'],
        'Component1ReferencedID' => [0x0076, 0x0070, 'US', '1'],
        'Component1ReferencedMatingFeatureSetID' => [0x0076, 0x0080, 'US', '1'],
        'Component1ReferencedMatingFeatureID' => [0x0076, 0x0090, 'US', '1'],
        'Component2ReferencedID' => [0x0076, 0x00a0, 'US', '1'],
        'Component2ReferencedMatingFeatureSetID' => [0x0076, 0x00b0, 'US', '1'],
        'Component2ReferencedMatingFeatureID' => [0x0076, 0x00c0, 'US', '1'],
        'ImplantTemplateGroupName' => [0x0078, 0x0001, 'LO', '1'],
        'ImplantTemplateGroupDescription' => [0x0078, 0x0010, 'ST', '1'],
        'ImplantTemplateGroupIssuer' => [0x0078, 0x0020, 'LO', '1'],
        'ImplantTemplateGroupVersion' => [0x0078, 0x0024, 'LO', '1'],
        'ReplacedImplantTemplateGroupSequence' => [0x0078, 0x0026, 'SQ', '1'],
        'ImplantTemplateGroupTargetAnatomySequence' => [0x0078, 0x0028, 'SQ', '1'],
        'ImplantTemplateGroupMembersSequence' => [0x0078, 0x002a, 'SQ', '1'],
        'ImplantTemplateGroupMemberID' => [0x0078, 0x002e, 'US', '1'],
        'ThreeDImplantTemplateGroupMemberMatchingPoint' => [0x0078, 0x0050, 'FD', '3'],
        'ThreeDImplantTemplateGroupMemberMatchingAxes' => [0x0078, 0x0060, 'FD', '9'],
        'ImplantTemplateGroupMemberMatching2DCoordinatesSequence' => [0x0078, 0x0070, 'SQ', '1'],
        'TwoDImplantTemplateGroupMemberMatchingPoint' => [0x0078, 0x0090, 'FD', '2'],
        'TwoDImplantTemplateGroupMemberMatchingAxes' => [0x0078, 0x00a0, 'FD', '4'],
        'ImplantTemplateGroupVariationDimensionSequence' => [0x0078, 0x00b0, 'SQ', '1'],
        'ImplantTemplateGroupVariationDimensionName' => [0x0078, 0x00b2, 'LO', '1'],
        'ImplantTemplateGroupVariationDimensionRankSequence' => [0x0078, 0x00b4, 'SQ', '1'],
        'ReferencedImplantTemplateGroupMemberID' => [0x0078, 0x00b6, 'US', '1'],
        'ImplantTemplateGroupVariationDimensionRank' => [0x0078, 0x00b8, 'US', '1'],
        'SurfaceScanAcquisitionTypeCodeSequence' => [0x0080, 0x0001, 'SQ', '1'],
        'SurfaceScanModeCodeSequence' => [0x0080, 0x0002, 'SQ', '1'],
        'RegistrationMethodCodeSequence' => [0x0080, 0x0003, 'SQ', '1'],
        'ShotDurationTime' => [0x0080, 0x0004, 'FD', '1'],
        'ShotOffsetTime' => [0x0080, 0x0005, 'FD', '1'],
        'SurfacePointPresentationValueData' => [0x0080, 0x0006, 'US', '1-n'],
        'SurfacePointColorCIELabValueData' => [0x0080, 0x0007, 'US', '3-3n'],
        'UVMappingSequence' => [0x0080, 0x0008, 'SQ', '1'],
        'TextureLabel' => [0x0080, 0x0009, 'SH', '1'],
        'UValueData' => [0x0080, 0x0010, 'OF', '1'],
        'VValueData' => [0x0080, 0x0011, 'OF', '1'],
        'ReferencedTextureSequence' => [0x0080, 0x0012, 'SQ', '1'],
        'ReferencedSurfaceDataSequence' => [0x0080, 0x0013, 'SQ', '1'],
        'AssessmentSummary' => [0x0082, 0x0001, 'CS', '1'],
        'AssessmentSummaryDescription' => [0x0082, 0x0003, 'UT', '1'],
        'AssessedSOPInstanceSequence' => [0x0082, 0x0004, 'SQ', '1'],
        'ReferencedComparisonSOPInstanceSequence' => [0x0082, 0x0005, 'SQ', '1'],
        'NumberOfAssessmentObservations' => [0x0082, 0x0006, 'UL', '1'],
        'AssessmentObservationsSequence' => [0x0082, 0x0007, 'SQ', '1'],
        'ObservationSignificance' => [0x0082, 0x0008, 'CS', '1'],
        'ObservationDescription' => [0x0082, 0x000a, 'UT', '1'],
        'StructuredConstraintObservationSequence' => [0x0082, 0x000c, 'SQ', '1'],
        'AssessedAttributeValueSequence' => [0x0082, 0x0010, 'SQ', '1'],
        'AssessmentSetID' => [0x0082, 0x0016, 'LO', '1'],
        'AssessmentRequesterSequence' => [0x0082, 0x0017, 'SQ', '1'],
        'SelectorAttributeName' => [0x0082, 0x0018, 'LO', '1'],
        'SelectorAttributeKeyword' => [0x0082, 0x0019, 'LO', '1'],
        'AssessmentTypeCodeSequence' => [0x0082, 0x0021, 'SQ', '1'],
        'ObservationBasisCodeSequence' => [0x0082, 0x0022, 'SQ', '1'],
        'AssessmentLabel' => [0x0082, 0x0023, 'LO', '1'],
        'ConstraintType' => [0x0082, 0x0032, 'CS', '1'],
        'SpecificationSelectionGuidance' => [0x0082, 0x0033, 'UT', '1'],
        'ConstraintValueSequence' => [0x0082, 0x0034, 'SQ', '1'],
        'RecommendedDefaultValueSequence' => [0x0082, 0x0035, 'SQ', '1'],
        'ConstraintViolationSignificance' => [0x0082, 0x0036, 'CS', '1'],
        'ConstraintViolationCondition' => [0x0082, 0x0037, 'UT', '1'],
        'ModifiableConstraintFlag' => [0x0082, 0x0038, 'CS', '1'],
        'StorageMediaFileSetID' => [0x0088, 0x0130, 'SH', '1'],
        'StorageMediaFileSetUID' => [0x0088, 0x0140, 'UI', '1'],
        'IconImageSequence' => [0x0088, 0x0200, 'SQ', '1'],
        'SOPInstanceStatus' => [0x0100, 0x0410, 'CS', '1'],
        'SOPAuthorizationDateTime' => [0x0100, 0x0420, 'DT', '1'],
        'SOPAuthorizationComment' => [0x0100, 0x0424, 'LT', '1'],
        'AuthorizationEquipmentCertificationNumber' => [0x0100, 0x0426, 'LO', '1'],
        'MACIDNumber' => [0x0400, 0x0005, 'US', '1'],
        'MACCalculationTransferSyntaxUID' => [0x0400, 0x0010, 'UI', '1'],
        'MACAlgorithm' => [0x0400, 0x0015, 'CS', '1'],
        'DataElementsSigned' => [0x0400, 0x0020, 'AT', '1-n'],
        'DigitalSignatureUID' => [0x0400, 0x0100, 'UI', '1'],
        'DigitalSignatureDateTime' => [0x0400, 0x0105, 'DT', '1'],
        'CertificateType' => [0x0400, 0x0110, 'CS', '1'],
        'CertificateOfSigner' => [0x0400, 0x0115, 'OB', '1'],
        'Signature' => [0x0400, 0x0120, 'OB', '1'],
        'CertifiedTimestampType' => [0x0400, 0x0305, 'CS', '1'],
        'CertifiedTimestamp' => [0x0400, 0x0310, 'OB', '1'],
        'DigitalSignaturePurposeCodeSequence' => [0x0400, 0x0401, 'SQ', '1'],
        'ReferencedDigitalSignatureSequence' => [0x0400, 0x0402, 'SQ', '1'],
        'ReferencedSOPInstanceMACSequence' => [0x0400, 0x0403, 'SQ', '1'],
        'MAC' => [0x0400, 0x0404, 'OB', '1'],
        'EncryptedAttributesSequence' => [0x0400, 0x0500, 'SQ', '1'],
        'EncryptedContentTransferSyntaxUID' => [0x0400, 0x0510, 'UI', '1'],
        'EncryptedContent' => [0x0400, 0x0520, 'OB', '1'],
        'ModifiedAttributesSequence' => [0x0400, 0x0550, 'SQ', '1'],
        'NonconformingModifiedAttributesSequence' => [0x0400, 0x0551, 'SQ', '1'],
        'NonconformingDataElementValue' => [0x0400, 0x0552, 'OB', '1'],
        'OriginalAttributesSequence' => [0x0400, 0x0561, 'SQ', '1'],
        'AttributeModificationDateTime' => [0x0400, 0x0562, 'DT', '1'],
        'ModifyingSystem' => [0x0400, 0x0563, 'LO', '1'],
        'SourceOfPreviousValues' => [0x0400, 0x0564, 'LO', '1'],
        'ReasonForTheAttributeModification' => [0x0400, 0x0565, 'CS', '1'],
        'InstanceOriginStatus' => [0x0400, 0x0600, 'CS', '1'],
        'NumberOfCopies' => [0x2000, 0x0010, 'IS', '1'],
        'PrinterConfigurationSequence' => [0x2000, 0x001e, 'SQ', '1'],
        'PrintPriority' => [0x2000, 0x0020, 'CS', '1'],
        'MediumType' => [0x2000, 0x0030, 'CS', '1'],
        'FilmDestination' => [0x2000, 0x0040, 'CS', '1'],
        'FilmSessionLabel' => [0x2000, 0x0050, 'LO', '1'],
        'MemoryAllocation' => [0x2000, 0x0060, 'IS', '1'],
        'MaximumMemoryAllocation' => [0x2000, 0x0061, 'IS', '1'],
        'MemoryBitDepth' => [0x2000, 0x00a0, 'US', '1'],
        'PrintingBitDepth' => [0x2000, 0x00a1, 'US', '1'],
        'MediaInstalledSequence' => [0x2000, 0x00a2, 'SQ', '1'],
        'OtherMediaAvailableSequence' => [0x2000, 0x00a4, 'SQ', '1'],
        'SupportedImageDisplayFormatsSequence' => [0x2000, 0x00a8, 'SQ', '1'],
        'ReferencedFilmBoxSequence' => [0x2000, 0x0500, 'SQ', '1'],
        'ImageDisplayFormat' => [0x2010, 0x0010, 'ST', '1'],
        'AnnotationDisplayFormatID' => [0x2010, 0x0030, 'CS', '1'],
        'FilmOrientation' => [0x2010, 0x0040, 'CS', '1'],
        'FilmSizeID' => [0x2010, 0x0050, 'CS', '1'],
        'PrinterResolutionID' => [0x2010, 0x0052, 'CS', '1'],
        'DefaultPrinterResolutionID' => [0x2010, 0x0054, 'CS', '1'],
        'MagnificationType' => [0x2010, 0x0060, 'CS', '1'],
        'SmoothingType' => [0x2010, 0x0080, 'CS', '1'],
        'DefaultMagnificationType' => [0x2010, 0x00a6, 'CS', '1'],
        'OtherMagnificationTypesAvailable' => [0x2010, 0x00a7, 'CS', '1-n'],
        'DefaultSmoothingType' => [0x2010, 0x00a8, 'CS', '1'],
        'OtherSmoothingTypesAvailable' => [0x2010, 0x00a9, 'CS', '1-n'],
        'BorderDensity' => [0x2010, 0x0100, 'CS', '1'],
        'EmptyImageDensity' => [0x2010, 0x0110, 'CS', '1'],
        'MinDensity' => [0x2010, 0x0120, 'US', '1'],
        'MaxDensity' => [0x2010, 0x0130, 'US', '1'],
        'Trim' => [0x2010, 0x0140, 'CS', '1'],
        'ConfigurationInformation' => [0x2010, 0x0150, 'ST', '1'],
        'ConfigurationInformationDescription' => [0x2010, 0x0152, 'LT', '1'],
        'MaximumCollatedFilms' => [0x2010, 0x0154, 'IS', '1'],
        'Illumination' => [0x2010, 0x015e, 'US', '1'],
        'ReflectedAmbientLight' => [0x2010, 0x0160, 'US', '1'],
        'PrinterPixelSpacing' => [0x2010, 0x0376, 'DS', '2'],
        'ReferencedFilmSessionSequence' => [0x2010, 0x0500, 'SQ', '1'],
        'ReferencedImageBoxSequence' => [0x2010, 0x0510, 'SQ', '1'],
        'ReferencedBasicAnnotationBoxSequence' => [0x2010, 0x0520, 'SQ', '1'],
        'ImageBoxPosition' => [0x2020, 0x0010, 'US', '1'],
        'Polarity' => [0x2020, 0x0020, 'CS', '1'],
        'RequestedImageSize' => [0x2020, 0x0030, 'DS', '1'],
        'RequestedDecimateCropBehavior' => [0x2020, 0x0040, 'CS', '1'],
        'RequestedResolutionID' => [0x2020, 0x0050, 'CS', '1'],
        'RequestedImageSizeFlag' => [0x2020, 0x00a0, 'CS', '1'],
        'DecimateCropResult' => [0x2020, 0x00a2, 'CS', '1'],
        'BasicGrayscaleImageSequence' => [0x2020, 0x0110, 'SQ', '1'],
        'BasicColorImageSequence' => [0x2020, 0x0111, 'SQ', '1'],
        'AnnotationPosition' => [0x2030, 0x0010, 'US', '1'],
        'TextString' => [0x2030, 0x0020, 'LO', '1'],
        'PresentationLUTSequence' => [0x2050, 0x0010, 'SQ', '1'],
        'PresentationLUTShape' => [0x2050, 0x0020, 'CS', '1'],
        'ReferencedPresentationLUTSequence' => [0x2050, 0x0500, 'SQ', '1'],
        'ExecutionStatus' => [0x2100, 0x0020, 'CS', '1'],
        'ExecutionStatusInfo' => [0x2100, 0x0030, 'CS', '1'],
        'CreationDate' => [0x2100, 0x0040, 'DA', '1'],
        'CreationTime' => [0x2100, 0x0050, 'TM', '1'],
        'Originator' => [0x2100, 0x0070, 'AE', '1'],
        'DestinationAE' => [0x2100, 0x0140, 'AE', '1'],
        'OwnerID' => [0x2100, 0x0160, 'SH', '1'],
        'NumberOfFilms' => [0x2100, 0x0170, 'IS', '1'],
        'PrinterStatus' => [0x2110, 0x0010, 'CS', '1'],
        'PrinterStatusInfo' => [0x2110, 0x0020, 'CS', '1'],
        'PrinterName' => [0x2110, 0x0030, 'LO', '1'],
        'ProposedStudySequence' => [0x2130, 0x00a0, 'SQ', '1'],
        'OriginalImageSequence' => [0x2130, 0x00c0, 'SQ', '1'],
        'LabelUsingInformationExtractedFromInstances' => [0x2200, 0x0001, 'CS', '1'],
        'LabelText' => [0x2200, 0x0002, 'UT', '1'],
        'LabelStyleSelection' => [0x2200, 0x0003, 'CS', '1'],
        'MediaDisposition' => [0x2200, 0x0004, 'LT', '1'],
        'BarcodeValue' => [0x2200, 0x0005, 'LT', '1'],
        'BarcodeSymbology' => [0x2200, 0x0006, 'CS', '1'],
        'AllowMediaSplitting' => [0x2200, 0x0007, 'CS', '1'],
        'IncludeNonDICOMObjects' => [0x2200, 0x0008, 'CS', '1'],
        'IncludeDisplayApplication' => [0x2200, 0x0009, 'CS', '1'],
        'PreserveCompositeInstancesAfterMediaCreation' => [0x2200, 0x000a, 'CS', '1'],
        'TotalNumberOfPiecesOfMediaCreated' => [0x2200, 0x000b, 'US', '1'],
        'RequestedMediaApplicationProfile' => [0x2200, 0x000c, 'LO', '1'],
        'ReferencedStorageMediaSequence' => [0x2200, 0x000d, 'SQ', '1'],
        'FailureAttributes' => [0x2200, 0x000e, 'AT', '1-n'],
        'AllowLossyCompression' => [0x2200, 0x000f, 'CS', '1'],
        'RequestPriority' => [0x2200, 0x0020, 'CS', '1'],
        'RTImageLabel' => [0x3002, 0x0002, 'SH', '1'],
        'RTImageName' => [0x3002, 0x0003, 'LO', '1'],
        'RTImageDescription' => [0x3002, 0x0004, 'ST', '1'],
        'ReportedValuesOrigin' => [0x3002, 0x000a, 'CS', '1'],
        'RTImagePlane' => [0x3002, 0x000c, 'CS', '1'],
        'XRayImageReceptorTranslation' => [0x3002, 0x000d, 'DS', '3'],
        'XRayImageReceptorAngle' => [0x3002, 0x000e, 'DS', '1'],
        'RTImageOrientation' => [0x3002, 0x0010, 'DS', '6'],
        'ImagePlanePixelSpacing' => [0x3002, 0x0011, 'DS', '2'],
        'RTImagePosition' => [0x3002, 0x0012, 'DS', '2'],
        'RadiationMachineName' => [0x3002, 0x0020, 'SH', '1'],
        'RadiationMachineSAD' => [0x3002, 0x0022, 'DS', '1'],
        'RadiationMachineSSD' => [0x3002, 0x0024, 'DS', '1'],
        'RTImageSID' => [0x3002, 0x0026, 'DS', '1'],
        'SourceToReferenceObjectDistance' => [0x3002, 0x0028, 'DS', '1'],
        'FractionNumber' => [0x3002, 0x0029, 'IS', '1'],
        'ExposureSequence' => [0x3002, 0x0030, 'SQ', '1'],
        'MetersetExposure' => [0x3002, 0x0032, 'DS', '1'],
        'DiaphragmPosition' => [0x3002, 0x0034, 'DS', '4'],
        'FluenceMapSequence' => [0x3002, 0x0040, 'SQ', '1'],
        'FluenceDataSource' => [0x3002, 0x0041, 'CS', '1'],
        'FluenceDataScale' => [0x3002, 0x0042, 'DS', '1'],
        'PrimaryFluenceModeSequence' => [0x3002, 0x0050, 'SQ', '1'],
        'FluenceMode' => [0x3002, 0x0051, 'CS', '1'],
        'FluenceModeID' => [0x3002, 0x0052, 'SH', '1'],
        'SelectedFrameNumber' => [0x3002, 0x0100, 'IS', '1'],
        'SelectedFrameFunctionalGroupsSequence' => [0x3002, 0x0101, 'SQ', '1'],
        'RTImageFrameGeneralContentSequence' => [0x3002, 0x0102, 'SQ', '1'],
        'RTImageFrameContextSequence' => [0x3002, 0x0103, 'SQ', '1'],
        'RTImageScopeSequence' => [0x3002, 0x0104, 'SQ', '1'],
        'BeamModifierCoordinatesPresenceFlag' => [0x3002, 0x0105, 'CS', '1'],
        'StartCumulativeMeterset' => [0x3002, 0x0106, 'FD', '1'],
        'StopCumulativeMeterset' => [0x3002, 0x0107, 'FD', '1'],
        'RTAcquisitionPatientPositionSequence' => [0x3002, 0x0108, 'SQ', '1'],
        'RTImageFrameImagingDevicePositionSequence' => [0x3002, 0x0109, 'SQ', '1'],
        'RTImageFramekVRadiationAcquisitionSequence' => [0x3002, 0x010a, 'SQ', '1'],
        'RTImageFrameMVRadiationAcquisitionSequence' => [0x3002, 0x010b, 'SQ', '1'],
        'RTImageFrameRadiationAcquisitionSequence' => [0x3002, 0x010c, 'SQ', '1'],
        'ImagingSourcePositionSequence' => [0x3002, 0x010d, 'SQ', '1'],
        'ImageReceptorPositionSequence' => [0x3002, 0x010e, 'SQ', '1'],
        'DevicePositionToEquipmentMappingMatrix' => [0x3002, 0x010f, 'FD', '16'],
        'DevicePositionParameterSequence' => [0x3002, 0x0110, 'SQ', '1'],
        'ImagingSourceLocationSpecificationType' => [0x3002, 0x0111, 'CS', '1'],
        'ImagingDeviceLocationMatrixSequence' => [0x3002, 0x0112, 'SQ', '1'],
        'ImagingDeviceLocationParameterSequence' => [0x3002, 0x0113, 'SQ', '1'],
        'ImagingApertureSequence' => [0x3002, 0x0114, 'SQ', '1'],
        'ImagingApertureSpecificationType' => [0x3002, 0x0115, 'CS', '1'],
        'NumberOfAcquisitionDevices' => [0x3002, 0x0116, 'US', '1'],
        'AcquisitionDeviceSequence' => [0x3002, 0x0117, 'SQ', '1'],
        'AcquisitionTaskSequence' => [0x3002, 0x0118, 'SQ', '1'],
        'AcquisitionTaskWorkitemCodeSequence' => [0x3002, 0x0119, 'SQ', '1'],
        'AcquisitionSubtaskSequence' => [0x3002, 0x011a, 'SQ', '1'],
        'SubtaskWorkitemCodeSequence' => [0x3002, 0x011b, 'SQ', '1'],
        'AcquisitionTaskIndex' => [0x3002, 0x011c, 'US', '1'],
        'AcquisitionSubtaskIndex' => [0x3002, 0x011d, 'US', '1'],
        'ReferencedBaselineParametersRTRadiationInstanceSequence' => [0x3002, 0x011e, 'SQ', '1'],
        'PositionAcquisitionTemplateIdentificationSequence' => [0x3002, 0x011f, 'SQ', '1'],
        'PositionAcquisitionTemplateID' => [0x3002, 0x0120, 'ST', '1'],
        'PositionAcquisitionTemplateName' => [0x3002, 0x0121, 'LO', '1'],
        'PositionAcquisitionTemplateCodeSequence' => [0x3002, 0x0122, 'SQ', '1'],
        'PositionAcquisitionTemplateDescription' => [0x3002, 0x0123, 'LT', '1'],
        'AcquisitionTaskApplicabilitySequence' => [0x3002, 0x0124, 'SQ', '1'],
        'ProjectionImagingAcquisitionParameterSequence' => [0x3002, 0x0125, 'SQ', '1'],
        'CTImagingAcquisitionParameterSequence' => [0x3002, 0x0126, 'SQ', '1'],
        'KVImagingGenerationParametersSequence' => [0x3002, 0x0127, 'SQ', '1'],
        'MVImagingGenerationParametersSequence' => [0x3002, 0x0128, 'SQ', '1'],
        'AcquisitionSignalType' => [0x3002, 0x0129, 'CS', '1'],
        'AcquisitionMethod' => [0x3002, 0x012a, 'CS', '1'],
        'ScanStartPositionSequence' => [0x3002, 0x012b, 'SQ', '1'],
        'ScanStopPositionSequence' => [0x3002, 0x012c, 'SQ', '1'],
        'ImagingSourceToBeamModifierDefinitionPlaneDistance' => [0x3002, 0x012d, 'FD', '1'],
        'ScanArcType' => [0x3002, 0x012e, 'CS', '1'],
        'DetectorPositioningType' => [0x3002, 0x012f, 'CS', '1'],
        'AdditionalRTAccessoryDeviceSequence' => [0x3002, 0x0130, 'SQ', '1'],
        'DeviceSpecificAcquisitionParameterSequence' => [0x3002, 0x0131, 'SQ', '1'],
        'ReferencedPositionReferenceInstanceSequence' => [0x3002, 0x0132, 'SQ', '1'],
        'EnergyDerivationCodeSequence' => [0x3002, 0x0133, 'SQ', '1'],
        'MaximumCumulativeMetersetExposure' => [0x3002, 0x0134, 'FD', '1'],
        'AcquisitionInitiationSequence' => [0x3002, 0x0135, 'SQ', '1'],
        'RTConeBeamImagingGeometrySequence' => [0x3002, 0x0136, 'SQ', '1'],
        'DVHType' => [0x3004, 0x0001, 'CS', '1'],
        'DoseUnits' => [0x3004, 0x0002, 'CS', '1'],
        'DoseType' => [0x3004, 0x0004, 'CS', '1'],
        'SpatialTransformOfDose' => [0x3004, 0x0005, 'CS', '1'],
        'DoseComment' => [0x3004, 0x0006, 'LO', '1'],
        'NormalizationPoint' => [0x3004, 0x0008, 'DS', '3'],
        'DoseSummationType' => [0x3004, 0x000a, 'CS', '1'],
        'GridFrameOffsetVector' => [0x3004, 0x000c, 'DS', '2-n'],
        'DoseGridScaling' => [0x3004, 0x000e, 'DS', '1'],
        'DoseValue' => [0x3004, 0x0012, 'DS', '1'],
        'TissueHeterogeneityCorrection' => [0x3004, 0x0014, 'CS', '1-3'],
        'RecommendedIsodoseLevelSequence' => [0x3004, 0x0016, 'SQ', '1'],
        'DoseUnitCodeSequence' => [0x3004, 0x0020, 'SQ', '1'],
        'RTDoseInterpretedTypeCodeSequence' => [0x3004, 0x0021, 'SQ', '1'],
        'RTDoseInterpretedTypeCodeModifierSequence' => [0x3004, 0x0022, 'SQ', '1'],
        'DoseRadiobiologicalInterpretationSequence' => [0x3004, 0x0023, 'SQ', '1'],
        'RTDoseIntentCodeSequence' => [0x3004, 0x0024, 'SQ', '1'],
        'DVHNormalizationPoint' => [0x3004, 0x0040, 'DS', '3'],
        'DVHNormalizationDoseValue' => [0x3004, 0x0042, 'DS', '1'],
        'DVHSequence' => [0x3004, 0x0050, 'SQ', '1'],
        'DVHDoseScaling' => [0x3004, 0x0052, 'DS', '1'],
        'DVHVolumeUnits' => [0x3004, 0x0054, 'CS', '1'],
        'DVHNumberOfBins' => [0x3004, 0x0056, 'IS', '1'],
        'DVHData' => [0x3004, 0x0058, 'DS', '2-2n'],
        'DVHReferencedROISequence' => [0x3004, 0x0060, 'SQ', '1'],
        'DVHROIContributionType' => [0x3004, 0x0062, 'CS', '1'],
        'DVHMinimumDose' => [0x3004, 0x0070, 'DS', '1'],
        'DVHMaximumDose' => [0x3004, 0x0072, 'DS', '1'],
        'DVHMeanDose' => [0x3004, 0x0074, 'DS', '1'],
        'DoseCalculationModelSequence' => [0x3004, 0x0080, 'SQ', '1'],
        'DoseCalculationAlgorithmSequence' => [0x3004, 0x0081, 'SQ', '1'],
        'CommissioningStatus' => [0x3004, 0x0082, 'CS', '1'],
        'DoseCalculationModelParameterSequence' => [0x3004, 0x0083, 'SQ', '1'],
        'DoseDepositionCalculationMedium' => [0x3004, 0x0084, 'CS', '1'],
        'StructureSetLabel' => [0x3006, 0x0002, 'SH', '1'],
        'StructureSetName' => [0x3006, 0x0004, 'LO', '1'],
        'StructureSetDescription' => [0x3006, 0x0006, 'ST', '1'],
        'StructureSetDate' => [0x3006, 0x0008, 'DA', '1'],
        'StructureSetTime' => [0x3006, 0x0009, 'TM', '1'],
        'ReferencedFrameOfReferenceSequence' => [0x3006, 0x0010, 'SQ', '1'],
        'RTReferencedStudySequence' => [0x3006, 0x0012, 'SQ', '1'],
        'RTReferencedSeriesSequence' => [0x3006, 0x0014, 'SQ', '1'],
        'ContourImageSequence' => [0x3006, 0x0016, 'SQ', '1'],
        'PredecessorStructureSetSequence' => [0x3006, 0x0018, 'SQ', '1'],
        'StructureSetROISequence' => [0x3006, 0x0020, 'SQ', '1'],
        'ROINumber' => [0x3006, 0x0022, 'IS', '1'],
        'ReferencedFrameOfReferenceUID' => [0x3006, 0x0024, 'UI', '1'],
        'ROIName' => [0x3006, 0x0026, 'LO', '1'],
        'ROIDescription' => [0x3006, 0x0028, 'ST', '1'],
        'ROIDisplayColor' => [0x3006, 0x002a, 'IS', '3'],
        'ROIVolume' => [0x3006, 0x002c, 'DS', '1'],
        'ROIDateTime' => [0x3006, 0x002d, 'DT', '1'],
        'ROIObservationDateTime' => [0x3006, 0x002e, 'DT', '1'],
        'RTRelatedROISequence' => [0x3006, 0x0030, 'SQ', '1'],
        'RTROIRelationship' => [0x3006, 0x0033, 'CS', '1'],
        'ROIGenerationAlgorithm' => [0x3006, 0x0036, 'CS', '1'],
        'ROIDerivationAlgorithmIdentificationSequence' => [0x3006, 0x0037, 'SQ', '1'],
        'ROIGenerationDescription' => [0x3006, 0x0038, 'LO', '1'],
        'ROIContourSequence' => [0x3006, 0x0039, 'SQ', '1'],
        'ContourSequence' => [0x3006, 0x0040, 'SQ', '1'],
        'ContourGeometricType' => [0x3006, 0x0042, 'CS', '1'],
        'NumberOfContourPoints' => [0x3006, 0x0046, 'IS', '1'],
        'ContourNumber' => [0x3006, 0x0048, 'IS', '1'],
        'SourcePixelPlanesCharacteristicsSequence' => [0x3006, 0x004a, 'SQ', '1'],
        'SourceSeriesSequence' => [0x3006, 0x004b, 'SQ', '1'],
        'SourceSeriesInformationSequence' => [0x3006, 0x004c, 'SQ', '1'],
        'ROICreatorSequence' => [0x3006, 0x004d, 'SQ', '1'],
        'ROIInterpreterSequence' => [0x3006, 0x004e, 'SQ', '1'],
        'ROIObservationContextCodeSequence' => [0x3006, 0x004f, 'SQ', '1'],
        'ContourData' => [0x3006, 0x0050, 'DS', '3-3n'],
        'RTROIObservationsSequence' => [0x3006, 0x0080, 'SQ', '1'],
        'ObservationNumber' => [0x3006, 0x0082, 'IS', '1'],
        'ReferencedROINumber' => [0x3006, 0x0084, 'IS', '1'],
        'RTROIIdentificationCodeSequence' => [0x3006, 0x0086, 'SQ', '1'],
        'RelatedRTROIObservationsSequence' => [0x3006, 0x00a0, 'SQ', '1'],
        'RTROIInterpretedType' => [0x3006, 0x00a4, 'CS', '1'],
        'ROIInterpreter' => [0x3006, 0x00a6, 'PN', '1'],
        'ROIPhysicalPropertiesSequence' => [0x3006, 0x00b0, 'SQ', '1'],
        'ROIPhysicalProperty' => [0x3006, 0x00b2, 'CS', '1'],
        'ROIPhysicalPropertyValue' => [0x3006, 0x00b4, 'DS', '1'],
        'ROIElementalCompositionSequence' => [0x3006, 0x00b6, 'SQ', '1'],
        'ROIElementalCompositionAtomicNumber' => [0x3006, 0x00b7, 'US', '1'],
        'ROIElementalCompositionAtomicMassFraction' => [0x3006, 0x00b8, 'FL', '1'],
        'FrameOfReferenceTransformationMatrix' => [0x3006, 0x00c6, 'DS', '16'],
        'FrameOfReferenceTransformationComment' => [0x3006, 0x00c8, 'LO', '1'],
        'PatientLocationCoordinatesSequence' => [0x3006, 0x00c9, 'SQ', '1'],
        'PatientLocationCoordinatesCodeSequence' => [0x3006, 0x00ca, 'SQ', '1'],
        'PatientSupportPositionSequence' => [0x3006, 0x00cb, 'SQ', '1'],
        'MeasuredDoseReferenceSequence' => [0x3008, 0x0010, 'SQ', '1'],
        'MeasuredDoseDescription' => [0x3008, 0x0012, 'ST', '1'],
        'MeasuredDoseType' => [0x3008, 0x0014, 'CS', '1'],
        'MeasuredDoseValue' => [0x3008, 0x0016, 'DS', '1'],
        'TreatmentSessionBeamSequence' => [0x3008, 0x0020, 'SQ', '1'],
        'TreatmentSessionIonBeamSequence' => [0x3008, 0x0021, 'SQ', '1'],
        'CurrentFractionNumber' => [0x3008, 0x0022, 'IS', '1'],
        'TreatmentControlPointDate' => [0x3008, 0x0024, 'DA', '1'],
        'TreatmentControlPointTime' => [0x3008, 0x0025, 'TM', '1'],
        'TreatmentTerminationStatus' => [0x3008, 0x002a, 'CS', '1'],
        'TreatmentVerificationStatus' => [0x3008, 0x002c, 'CS', '1'],
        'ReferencedTreatmentRecordSequence' => [0x3008, 0x0030, 'SQ', '1'],
        'SpecifiedPrimaryMeterset' => [0x3008, 0x0032, 'DS', '1'],
        'SpecifiedSecondaryMeterset' => [0x3008, 0x0033, 'DS', '1'],
        'DeliveredPrimaryMeterset' => [0x3008, 0x0036, 'DS', '1'],
        'DeliveredSecondaryMeterset' => [0x3008, 0x0037, 'DS', '1'],
        'SpecifiedTreatmentTime' => [0x3008, 0x003a, 'DS', '1'],
        'DeliveredTreatmentTime' => [0x3008, 0x003b, 'DS', '1'],
        'ControlPointDeliverySequence' => [0x3008, 0x0040, 'SQ', '1'],
        'IonControlPointDeliverySequence' => [0x3008, 0x0041, 'SQ', '1'],
        'SpecifiedMeterset' => [0x3008, 0x0042, 'DS', '1'],
        'DeliveredMeterset' => [0x3008, 0x0044, 'DS', '1'],
        'MetersetRateSet' => [0x3008, 0x0045, 'FL', '1'],
        'MetersetRateDelivered' => [0x3008, 0x0046, 'FL', '1'],
        'ScanSpotMetersetsDelivered' => [0x3008, 0x0047, 'FL', '1-n'],
        'DoseRateDelivered' => [0x3008, 0x0048, 'DS', '1'],
        'TreatmentSummaryCalculatedDoseReferenceSequence' => [0x3008, 0x0050, 'SQ', '1'],
        'CumulativeDoseToDoseReference' => [0x3008, 0x0052, 'DS', '1'],
        'FirstTreatmentDate' => [0x3008, 0x0054, 'DA', '1'],
        'MostRecentTreatmentDate' => [0x3008, 0x0056, 'DA', '1'],
        'NumberOfFractionsDelivered' => [0x3008, 0x005a, 'IS', '1'],
        'OverrideSequence' => [0x3008, 0x0060, 'SQ', '1'],
        'ParameterSequencePointer' => [0x3008, 0x0061, 'AT', '1'],
        'OverrideParameterPointer' => [0x3008, 0x0062, 'AT', '1'],
        'ParameterItemIndex' => [0x3008, 0x0063, 'IS', '1'],
        'MeasuredDoseReferenceNumber' => [0x3008, 0x0064, 'IS', '1'],
        'ParameterPointer' => [0x3008, 0x0065, 'AT', '1'],
        'OverrideReason' => [0x3008, 0x0066, 'ST', '1'],
        'ParameterValueNumber' => [0x3008, 0x0067, 'US', '1'],
        'CorrectedParameterSequence' => [0x3008, 0x0068, 'SQ', '1'],
        'CorrectionValue' => [0x3008, 0x006a, 'FL', '1'],
        'CalculatedDoseReferenceSequence' => [0x3008, 0x0070, 'SQ', '1'],
        'CalculatedDoseReferenceNumber' => [0x3008, 0x0072, 'IS', '1'],
        'CalculatedDoseReferenceDescription' => [0x3008, 0x0074, 'ST', '1'],
        'CalculatedDoseReferenceDoseValue' => [0x3008, 0x0076, 'DS', '1'],
        'StartMeterset' => [0x3008, 0x0078, 'DS', '1'],
        'EndMeterset' => [0x3008, 0x007a, 'DS', '1'],
        'ReferencedMeasuredDoseReferenceSequence' => [0x3008, 0x0080, 'SQ', '1'],
        'ReferencedMeasuredDoseReferenceNumber' => [0x3008, 0x0082, 'IS', '1'],
        'ReferencedCalculatedDoseReferenceSequence' => [0x3008, 0x0090, 'SQ', '1'],
        'ReferencedCalculatedDoseReferenceNumber' => [0x3008, 0x0092, 'IS', '1'],
        'BeamLimitingDeviceLeafPairsSequence' => [0x3008, 0x00a0, 'SQ', '1'],
        'EnhancedRTBeamLimitingDeviceSequence' => [0x3008, 0x00a1, 'SQ', '1'],
        'EnhancedRTBeamLimitingOpeningSequence' => [0x3008, 0x00a2, 'SQ', '1'],
        'EnhancedRTBeamLimitingDeviceDefinitionFlag' => [0x3008, 0x00a3, 'CS', '1'],
        'ParallelRTBeamDelimiterOpeningExtents' => [0x3008, 0x00a4, 'FD', '2-2n'],
        'RecordedWedgeSequence' => [0x3008, 0x00b0, 'SQ', '1'],
        'RecordedCompensatorSequence' => [0x3008, 0x00c0, 'SQ', '1'],
        'RecordedBlockSequence' => [0x3008, 0x00d0, 'SQ', '1'],
        'RecordedBlockSlabSequence' => [0x3008, 0x00d1, 'SQ', '1'],
        'TreatmentSummaryMeasuredDoseReferenceSequence' => [0x3008, 0x00e0, 'SQ', '1'],
        'RecordedSnoutSequence' => [0x3008, 0x00f0, 'SQ', '1'],
        'RecordedRangeShifterSequence' => [0x3008, 0x00f2, 'SQ', '1'],
        'RecordedLateralSpreadingDeviceSequence' => [0x3008, 0x00f4, 'SQ', '1'],
        'RecordedRangeModulatorSequence' => [0x3008, 0x00f6, 'SQ', '1'],
        'RecordedSourceSequence' => [0x3008, 0x0100, 'SQ', '1'],
        'SourceSerialNumber' => [0x3008, 0x0105, 'LO', '1'],
        'TreatmentSessionApplicationSetupSequence' => [0x3008, 0x0110, 'SQ', '1'],
        'ApplicationSetupCheck' => [0x3008, 0x0116, 'CS', '1'],
        'RecordedBrachyAccessoryDeviceSequence' => [0x3008, 0x0120, 'SQ', '1'],
        'ReferencedBrachyAccessoryDeviceNumber' => [0x3008, 0x0122, 'IS', '1'],
        'RecordedChannelSequence' => [0x3008, 0x0130, 'SQ', '1'],
        'SpecifiedChannelTotalTime' => [0x3008, 0x0132, 'DS', '1'],
        'DeliveredChannelTotalTime' => [0x3008, 0x0134, 'DS', '1'],
        'SpecifiedNumberOfPulses' => [0x3008, 0x0136, 'IS', '1'],
        'DeliveredNumberOfPulses' => [0x3008, 0x0138, 'IS', '1'],
        'SpecifiedPulseRepetitionInterval' => [0x3008, 0x013a, 'DS', '1'],
        'DeliveredPulseRepetitionInterval' => [0x3008, 0x013c, 'DS', '1'],
        'RecordedSourceApplicatorSequence' => [0x3008, 0x0140, 'SQ', '1'],
        'ReferencedSourceApplicatorNumber' => [0x3008, 0x0142, 'IS', '1'],
        'RecordedChannelShieldSequence' => [0x3008, 0x0150, 'SQ', '1'],
        'ReferencedChannelShieldNumber' => [0x3008, 0x0152, 'IS', '1'],
        'BrachyControlPointDeliveredSequence' => [0x3008, 0x0160, 'SQ', '1'],
        'SafePositionExitDate' => [0x3008, 0x0162, 'DA', '1'],
        'SafePositionExitTime' => [0x3008, 0x0164, 'TM', '1'],
        'SafePositionReturnDate' => [0x3008, 0x0166, 'DA', '1'],
        'SafePositionReturnTime' => [0x3008, 0x0168, 'TM', '1'],
        'PulseSpecificBrachyControlPointDeliveredSequence' => [0x3008, 0x0171, 'SQ', '1'],
        'PulseNumber' => [0x3008, 0x0172, 'US', '1'],
        'BrachyPulseControlPointDeliveredSequence' => [0x3008, 0x0173, 'SQ', '1'],
        'CurrentTreatmentStatus' => [0x3008, 0x0200, 'CS', '1'],
        'TreatmentStatusComment' => [0x3008, 0x0202, 'ST', '1'],
        'FractionGroupSummarySequence' => [0x3008, 0x0220, 'SQ', '1'],
        'ReferencedFractionNumber' => [0x3008, 0x0223, 'IS', '1'],
        'FractionGroupType' => [0x3008, 0x0224, 'CS', '1'],
        'BeamStopperPosition' => [0x3008, 0x0230, 'CS', '1'],
        'FractionStatusSummarySequence' => [0x3008, 0x0240, 'SQ', '1'],
        'TreatmentDate' => [0x3008, 0x0250, 'DA', '1'],
        'TreatmentTime' => [0x3008, 0x0251, 'TM', '1'],
        'RTPlanLabel' => [0x300a, 0x0002, 'SH', '1'],
        'RTPlanName' => [0x300a, 0x0003, 'LO', '1'],
        'RTPlanDescription' => [0x300a, 0x0004, 'ST', '1'],
        'RTPlanDate' => [0x300a, 0x0006, 'DA', '1'],
        'RTPlanTime' => [0x300a, 0x0007, 'TM', '1'],
        'TreatmentProtocols' => [0x300a, 0x0009, 'LO', '1-n'],
        'PlanIntent' => [0x300a, 0x000a, 'CS', '1'],
        'RTPlanGeometry' => [0x300a, 0x000c, 'CS', '1'],
        'PrescriptionDescription' => [0x300a, 0x000e, 'ST', '1'],
        'DoseReferenceSequence' => [0x300a, 0x0010, 'SQ', '1'],
        'DoseReferenceNumber' => [0x300a, 0x0012, 'IS', '1'],
        'DoseReferenceUID' => [0x300a, 0x0013, 'UI', '1'],
        'DoseReferenceStructureType' => [0x300a, 0x0014, 'CS', '1'],
        'NominalBeamEnergyUnit' => [0x300a, 0x0015, 'CS', '1'],
        'DoseReferenceDescription' => [0x300a, 0x0016, 'LO', '1'],
        'DoseReferencePointCoordinates' => [0x300a, 0x0018, 'DS', '3'],
        'NominalPriorDose' => [0x300a, 0x001a, 'DS', '1'],
        'DoseReferenceType' => [0x300a, 0x0020, 'CS', '1'],
        'ConstraintWeight' => [0x300a, 0x0021, 'DS', '1'],
        'DeliveryWarningDose' => [0x300a, 0x0022, 'DS', '1'],
        'DeliveryMaximumDose' => [0x300a, 0x0023, 'DS', '1'],
        'TargetMinimumDose' => [0x300a, 0x0025, 'DS', '1'],
        'TargetPrescriptionDose' => [0x300a, 0x0026, 'DS', '1'],
        'TargetMaximumDose' => [0x300a, 0x0027, 'DS', '1'],
        'TargetUnderdoseVolumeFraction' => [0x300a, 0x0028, 'DS', '1'],
        'OrganAtRiskFullVolumeDose' => [0x300a, 0x002a, 'DS', '1'],
        'OrganAtRiskLimitDose' => [0x300a, 0x002b, 'DS', '1'],
        'OrganAtRiskMaximumDose' => [0x300a, 0x002c, 'DS', '1'],
        'OrganAtRiskOverdoseVolumeFraction' => [0x300a, 0x002d, 'DS', '1'],
        'ToleranceTableSequence' => [0x300a, 0x0040, 'SQ', '1'],
        'ToleranceTableNumber' => [0x300a, 0x0042, 'IS', '1'],
        'ToleranceTableLabel' => [0x300a, 0x0043, 'SH', '1'],
        'GantryAngleTolerance' => [0x300a, 0x0044, 'DS', '1'],
        'BeamLimitingDeviceAngleTolerance' => [0x300a, 0x0046, 'DS', '1'],
        'BeamLimitingDeviceToleranceSequence' => [0x300a, 0x0048, 'SQ', '1'],
        'BeamLimitingDevicePositionTolerance' => [0x300a, 0x004a, 'DS', '1'],
        'SnoutPositionTolerance' => [0x300a, 0x004b, 'FL', '1'],
        'PatientSupportAngleTolerance' => [0x300a, 0x004c, 'DS', '1'],
        'TableTopEccentricAngleTolerance' => [0x300a, 0x004e, 'DS', '1'],
        'TableTopPitchAngleTolerance' => [0x300a, 0x004f, 'FL', '1'],
        'TableTopRollAngleTolerance' => [0x300a, 0x0050, 'FL', '1'],
        'TableTopVerticalPositionTolerance' => [0x300a, 0x0051, 'DS', '1'],
        'TableTopLongitudinalPositionTolerance' => [0x300a, 0x0052, 'DS', '1'],
        'TableTopLateralPositionTolerance' => [0x300a, 0x0053, 'DS', '1'],
        'TableTopPositionAlignmentUID' => [0x300a, 0x0054, 'UI', '1'],
        'RTPlanRelationship' => [0x300a, 0x0055, 'CS', '1'],
        'FractionGroupSequence' => [0x300a, 0x0070, 'SQ', '1'],
        'FractionGroupNumber' => [0x300a, 0x0071, 'IS', '1'],
        'FractionGroupDescription' => [0x300a, 0x0072, 'LO', '1'],
        'NumberOfFractionsPlanned' => [0x300a, 0x0078, 'IS', '1'],
        'NumberOfFractionPatternDigitsPerDay' => [0x300a, 0x0079, 'IS', '1'],
        'RepeatFractionCycleLength' => [0x300a, 0x007a, 'IS', '1'],
        'FractionPattern' => [0x300a, 0x007b, 'LT', '1'],
        'NumberOfBeams' => [0x300a, 0x0080, 'IS', '1'],
        'ReferencedDoseReferenceUID' => [0x300a, 0x0083, 'UI', '1'],
        'BeamDose' => [0x300a, 0x0084, 'DS', '1'],
        'BeamMeterset' => [0x300a, 0x0086, 'DS', '1'],
        'BeamDosePointDepth' => [0x300a, 0x0088, 'FL', '1'],
        'BeamDosePointEquivalentDepth' => [0x300a, 0x0089, 'FL', '1'],
        'BeamDosePointSSD' => [0x300a, 0x008a, 'FL', '1'],
        'BeamDoseMeaning' => [0x300a, 0x008b, 'CS', '1'],
        'BeamDoseVerificationControlPointSequence' => [0x300a, 0x008c, 'SQ', '1'],
        'BeamDoseType' => [0x300a, 0x0090, 'CS', '1'],
        'AlternateBeamDose' => [0x300a, 0x0091, 'DS', '1'],
        'AlternateBeamDoseType' => [0x300a, 0x0092, 'CS', '1'],
        'DepthValueAveragingFlag' => [0x300a, 0x0093, 'CS', '1'],
        'BeamDosePointSourceToExternalContourDistance' => [0x300a, 0x0094, 'DS', '1'],
        'NumberOfBrachyApplicationSetups' => [0x300a, 0x00a0, 'IS', '1'],
        'BrachyApplicationSetupDoseSpecificationPoint' => [0x300a, 0x00a2, 'DS', '3'],
        'BrachyApplicationSetupDose' => [0x300a, 0x00a4, 'DS', '1'],
        'BeamSequence' => [0x300a, 0x00b0, 'SQ', '1'],
        'TreatmentMachineName' => [0x300a, 0x00b2, 'SH', '1'],
        'PrimaryDosimeterUnit' => [0x300a, 0x00b3, 'CS', '1'],
        'SourceAxisDistance' => [0x300a, 0x00b4, 'DS', '1'],
        'BeamLimitingDeviceSequence' => [0x300a, 0x00b6, 'SQ', '1'],
        'RTBeamLimitingDeviceType' => [0x300a, 0x00b8, 'CS', '1'],
        'SourceToBeamLimitingDeviceDistance' => [0x300a, 0x00ba, 'DS', '1'],
        'IsocenterToBeamLimitingDeviceDistance' => [0x300a, 0x00bb, 'FL', '1'],
        'NumberOfLeafJawPairs' => [0x300a, 0x00bc, 'IS', '1'],
        'LeafPositionBoundaries' => [0x300a, 0x00be, 'DS', '3-n'],
        'BeamNumber' => [0x300a, 0x00c0, 'IS', '1'],
        'BeamName' => [0x300a, 0x00c2, 'LO', '1'],
        'BeamDescription' => [0x300a, 0x00c3, 'ST', '1'],
        'BeamType' => [0x300a, 0x00c4, 'CS', '1'],
        'BeamDeliveryDurationLimit' => [0x300a, 0x00c5, 'FD', '1'],
        'RadiationType' => [0x300a, 0x00c6, 'CS', '1'],
        'HighDoseTechniqueType' => [0x300a, 0x00c7, 'CS', '1'],
        'ReferenceImageNumber' => [0x300a, 0x00c8, 'IS', '1'],
        'PlannedVerificationImageSequence' => [0x300a, 0x00ca, 'SQ', '1'],
        'ImagingDeviceSpecificAcquisitionParameters' => [0x300a, 0x00cc, 'LO', '1-n'],
        'TreatmentDeliveryType' => [0x300a, 0x00ce, 'CS', '1'],
        'NumberOfWedges' => [0x300a, 0x00d0, 'IS', '1'],
        'WedgeSequence' => [0x300a, 0x00d1, 'SQ', '1'],
        'WedgeNumber' => [0x300a, 0x00d2, 'IS', '1'],
        'WedgeType' => [0x300a, 0x00d3, 'CS', '1'],
        'WedgeID' => [0x300a, 0x00d4, 'SH', '1'],
        'WedgeAngle' => [0x300a, 0x00d5, 'IS', '1'],
        'WedgeFactor' => [0x300a, 0x00d6, 'DS', '1'],
        'TotalWedgeTrayWaterEquivalentThickness' => [0x300a, 0x00d7, 'FL', '1'],
        'WedgeOrientation' => [0x300a, 0x00d8, 'DS', '1'],
        'IsocenterToWedgeTrayDistance' => [0x300a, 0x00d9, 'FL', '1'],
        'SourceToWedgeTrayDistance' => [0x300a, 0x00da, 'DS', '1'],
        'WedgeThinEdgePosition' => [0x300a, 0x00db, 'FL', '1'],
        'BolusID' => [0x300a, 0x00dc, 'SH', '1'],
        'BolusDescription' => [0x300a, 0x00dd, 'ST', '1'],
        'EffectiveWedgeAngle' => [0x300a, 0x00de, 'DS', '1'],
        'NumberOfCompensators' => [0x300a, 0x00e0, 'IS', '1'],
        'MaterialID' => [0x300a, 0x00e1, 'SH', '1'],
        'TotalCompensatorTrayFactor' => [0x300a, 0x00e2, 'DS', '1'],
        'CompensatorSequence' => [0x300a, 0x00e3, 'SQ', '1'],
        'CompensatorNumber' => [0x300a, 0x00e4, 'IS', '1'],
        'CompensatorID' => [0x300a, 0x00e5, 'SH', '1'],
        'SourceToCompensatorTrayDistance' => [0x300a, 0x00e6, 'DS', '1'],
        'CompensatorRows' => [0x300a, 0x00e7, 'IS', '1'],
        'CompensatorColumns' => [0x300a, 0x00e8, 'IS', '1'],
        'CompensatorPixelSpacing' => [0x300a, 0x00e9, 'DS', '2'],
        'CompensatorPosition' => [0x300a, 0x00ea, 'DS', '2'],
        'CompensatorTransmissionData' => [0x300a, 0x00eb, 'DS', '1-n'],
        'CompensatorThicknessData' => [0x300a, 0x00ec, 'DS', '1-n'],
        'NumberOfBoli' => [0x300a, 0x00ed, 'IS', '1'],
        'CompensatorType' => [0x300a, 0x00ee, 'CS', '1'],
        'CompensatorTrayID' => [0x300a, 0x00ef, 'SH', '1'],
        'NumberOfBlocks' => [0x300a, 0x00f0, 'IS', '1'],
        'TotalBlockTrayFactor' => [0x300a, 0x00f2, 'DS', '1'],
        'TotalBlockTrayWaterEquivalentThickness' => [0x300a, 0x00f3, 'FL', '1'],
        'BlockSequence' => [0x300a, 0x00f4, 'SQ', '1'],
        'BlockTrayID' => [0x300a, 0x00f5, 'SH', '1'],
        'SourceToBlockTrayDistance' => [0x300a, 0x00f6, 'DS', '1'],
        'IsocenterToBlockTrayDistance' => [0x300a, 0x00f7, 'FL', '1'],
        'BlockType' => [0x300a, 0x00f8, 'CS', '1'],
        'AccessoryCode' => [0x300a, 0x00f9, 'LO', '1'],
        'BlockDivergence' => [0x300a, 0x00fa, 'CS', '1'],
        'BlockMountingPosition' => [0x300a, 0x00fb, 'CS', '1'],
        'BlockNumber' => [0x300a, 0x00fc, 'IS', '1'],
        'BlockName' => [0x300a, 0x00fe, 'LO', '1'],
        'BlockThickness' => [0x300a, 0x0100, 'DS', '1'],
        'BlockTransmission' => [0x300a, 0x0102, 'DS', '1'],
        'BlockNumberOfPoints' => [0x300a, 0x0104, 'IS', '1'],
        'BlockData' => [0x300a, 0x0106, 'DS', '2-2n'],
        'ApplicatorSequence' => [0x300a, 0x0107, 'SQ', '1'],
        'ApplicatorID' => [0x300a, 0x0108, 'SH', '1'],
        'ApplicatorType' => [0x300a, 0x0109, 'CS', '1'],
        'ApplicatorDescription' => [0x300a, 0x010a, 'LO', '1'],
        'CumulativeDoseReferenceCoefficient' => [0x300a, 0x010c, 'DS', '1'],
        'FinalCumulativeMetersetWeight' => [0x300a, 0x010e, 'DS', '1'],
        'NumberOfControlPoints' => [0x300a, 0x0110, 'IS', '1'],
        'ControlPointSequence' => [0x300a, 0x0111, 'SQ', '1'],
        'ControlPointIndex' => [0x300a, 0x0112, 'IS', '1'],
        'NominalBeamEnergy' => [0x300a, 0x0114, 'DS', '1'],
        'DoseRateSet' => [0x300a, 0x0115, 'DS', '1'],
        'WedgePositionSequence' => [0x300a, 0x0116, 'SQ', '1'],
        'WedgePosition' => [0x300a, 0x0118, 'CS', '1'],
        'BeamLimitingDevicePositionSequence' => [0x300a, 0x011a, 'SQ', '1'],
        'LeafJawPositions' => [0x300a, 0x011c, 'DS', '2-2n'],
        'GantryAngle' => [0x300a, 0x011e, 'DS', '1'],
        'GantryRotationDirection' => [0x300a, 0x011f, 'CS', '1'],
        'BeamLimitingDeviceAngle' => [0x300a, 0x0120, 'DS', '1'],
        'BeamLimitingDeviceRotationDirection' => [0x300a, 0x0121, 'CS', '1'],
        'PatientSupportAngle' => [0x300a, 0x0122, 'DS', '1'],
        'PatientSupportRotationDirection' => [0x300a, 0x0123, 'CS', '1'],
        'TableTopEccentricAxisDistance' => [0x300a, 0x0124, 'DS', '1'],
        'TableTopEccentricAngle' => [0x300a, 0x0125, 'DS', '1'],
        'TableTopEccentricRotationDirection' => [0x300a, 0x0126, 'CS', '1'],
        'TableTopVerticalPosition' => [0x300a, 0x0128, 'DS', '1'],
        'TableTopLongitudinalPosition' => [0x300a, 0x0129, 'DS', '1'],
        'TableTopLateralPosition' => [0x300a, 0x012a, 'DS', '1'],
        'IsocenterPosition' => [0x300a, 0x012c, 'DS', '3'],
        'SurfaceEntryPoint' => [0x300a, 0x012e, 'DS', '3'],
        'SourceToSurfaceDistance' => [0x300a, 0x0130, 'DS', '1'],
        'AverageBeamDosePointSourceToExternalContourDistance' => [0x300a, 0x0131, 'FL', '1'],
        'SourceToExternalContourDistance' => [0x300a, 0x0132, 'FL', '1'],
        'ExternalContourEntryPoint' => [0x300a, 0x0133, 'FL', '3'],
        'CumulativeMetersetWeight' => [0x300a, 0x0134, 'DS', '1'],
        'TableTopPitchAngle' => [0x300a, 0x0140, 'FL', '1'],
        'TableTopPitchRotationDirection' => [0x300a, 0x0142, 'CS', '1'],
        'TableTopRollAngle' => [0x300a, 0x0144, 'FL', '1'],
        'TableTopRollRotationDirection' => [0x300a, 0x0146, 'CS', '1'],
        'HeadFixationAngle' => [0x300a, 0x0148, 'FL', '1'],
        'GantryPitchAngle' => [0x300a, 0x014a, 'FL', '1'],
        'GantryPitchRotationDirection' => [0x300a, 0x014c, 'CS', '1'],
        'GantryPitchAngleTolerance' => [0x300a, 0x014e, 'FL', '1'],
        'FixationEye' => [0x300a, 0x0150, 'CS', '1'],
        'ChairHeadFramePosition' => [0x300a, 0x0151, 'DS', '1'],
        'HeadFixationAngleTolerance' => [0x300a, 0x0152, 'DS', '1'],
        'ChairHeadFramePositionTolerance' => [0x300a, 0x0153, 'DS', '1'],
        'FixationLightAzimuthalAngleTolerance' => [0x300a, 0x0154, 'DS', '1'],
        'FixationLightPolarAngleTolerance' => [0x300a, 0x0155, 'DS', '1'],
        'PatientSetupSequence' => [0x300a, 0x0180, 'SQ', '1'],
        'PatientSetupNumber' => [0x300a, 0x0182, 'IS', '1'],
        'PatientSetupLabel' => [0x300a, 0x0183, 'LO', '1'],
        'PatientAdditionalPosition' => [0x300a, 0x0184, 'LO', '1'],
        'FixationDeviceSequence' => [0x300a, 0x0190, 'SQ', '1'],
        'FixationDeviceType' => [0x300a, 0x0192, 'CS', '1'],
        'FixationDeviceLabel' => [0x300a, 0x0194, 'SH', '1'],
        'FixationDeviceDescription' => [0x300a, 0x0196, 'ST', '1'],
        'FixationDevicePosition' => [0x300a, 0x0198, 'SH', '1'],
        'FixationDevicePitchAngle' => [0x300a, 0x0199, 'FL', '1'],
        'FixationDeviceRollAngle' => [0x300a, 0x019a, 'FL', '1'],
        'ShieldingDeviceSequence' => [0x300a, 0x01a0, 'SQ', '1'],
        'ShieldingDeviceType' => [0x300a, 0x01a2, 'CS', '1'],
        'ShieldingDeviceLabel' => [0x300a, 0x01a4, 'SH', '1'],
        'ShieldingDeviceDescription' => [0x300a, 0x01a6, 'ST', '1'],
        'ShieldingDevicePosition' => [0x300a, 0x01a8, 'SH', '1'],
        'SetupTechnique' => [0x300a, 0x01b0, 'CS', '1'],
        'SetupTechniqueDescription' => [0x300a, 0x01b2, 'ST', '1'],
        'SetupDeviceSequence' => [0x300a, 0x01b4, 'SQ', '1'],
        'SetupDeviceType' => [0x300a, 0x01b6, 'CS', '1'],
        'SetupDeviceLabel' => [0x300a, 0x01b8, 'SH', '1'],
        'SetupDeviceDescription' => [0x300a, 0x01ba, 'ST', '1'],
        'SetupDeviceParameter' => [0x300a, 0x01bc, 'DS', '1'],
        'SetupReferenceDescription' => [0x300a, 0x01d0, 'ST', '1'],
        'TableTopVerticalSetupDisplacement' => [0x300a, 0x01d2, 'DS', '1'],
        'TableTopLongitudinalSetupDisplacement' => [0x300a, 0x01d4, 'DS', '1'],
        'TableTopLateralSetupDisplacement' => [0x300a, 0x01d6, 'DS', '1'],
        'BrachyTreatmentTechnique' => [0x300a, 0x0200, 'CS', '1'],
        'BrachyTreatmentType' => [0x300a, 0x0202, 'CS', '1'],
        'TreatmentMachineSequence' => [0x300a, 0x0206, 'SQ', '1'],
        'SourceSequence' => [0x300a, 0x0210, 'SQ', '1'],
        'SourceNumber' => [0x300a, 0x0212, 'IS', '1'],
        'SourceType' => [0x300a, 0x0214, 'CS', '1'],
        'SourceManufacturer' => [0x300a, 0x0216, 'LO', '1'],
        'ActiveSourceDiameter' => [0x300a, 0x0218, 'DS', '1'],
        'ActiveSourceLength' => [0x300a, 0x021a, 'DS', '1'],
        'SourceModelID' => [0x300a, 0x021b, 'SH', '1'],
        'SourceDescription' => [0x300a, 0x021c, 'LO', '1'],
        'SourceEncapsulationNominalThickness' => [0x300a, 0x0222, 'DS', '1'],
        'SourceEncapsulationNominalTransmission' => [0x300a, 0x0224, 'DS', '1'],
        'SourceIsotopeName' => [0x300a, 0x0226, 'LO', '1'],
        'SourceIsotopeHalfLife' => [0x300a, 0x0228, 'DS', '1'],
        'SourceStrengthUnits' => [0x300a, 0x0229, 'CS', '1'],
        'ReferenceAirKermaRate' => [0x300a, 0x022a, 'DS', '1'],
        'SourceStrength' => [0x300a, 0x022b, 'DS', '1'],
        'SourceStrengthReferenceDate' => [0x300a, 0x022c, 'DA', '1'],
        'SourceStrengthReferenceTime' => [0x300a, 0x022e, 'TM', '1'],
        'ApplicationSetupSequence' => [0x300a, 0x0230, 'SQ', '1'],
        'ApplicationSetupType' => [0x300a, 0x0232, 'CS', '1'],
        'ApplicationSetupNumber' => [0x300a, 0x0234, 'IS', '1'],
        'ApplicationSetupName' => [0x300a, 0x0236, 'LO', '1'],
        'ApplicationSetupManufacturer' => [0x300a, 0x0238, 'LO', '1'],
        'TemplateNumber' => [0x300a, 0x0240, 'IS', '1'],
        'TemplateType' => [0x300a, 0x0242, 'SH', '1'],
        'TemplateName' => [0x300a, 0x0244, 'LO', '1'],
        'TotalReferenceAirKerma' => [0x300a, 0x0250, 'DS', '1'],
        'BrachyAccessoryDeviceSequence' => [0x300a, 0x0260, 'SQ', '1'],
        'BrachyAccessoryDeviceNumber' => [0x300a, 0x0262, 'IS', '1'],
        'BrachyAccessoryDeviceID' => [0x300a, 0x0263, 'SH', '1'],
        'BrachyAccessoryDeviceType' => [0x300a, 0x0264, 'CS', '1'],
        'BrachyAccessoryDeviceName' => [0x300a, 0x0266, 'LO', '1'],
        'BrachyAccessoryDeviceNominalThickness' => [0x300a, 0x026a, 'DS', '1'],
        'BrachyAccessoryDeviceNominalTransmission' => [0x300a, 0x026c, 'DS', '1'],
        'ChannelEffectiveLength' => [0x300a, 0x0271, 'DS', '1'],
        'ChannelInnerLength' => [0x300a, 0x0272, 'DS', '1'],
        'AfterloaderChannelID' => [0x300a, 0x0273, 'SH', '1'],
        'SourceApplicatorTipLength' => [0x300a, 0x0274, 'DS', '1'],
        'ChannelSequence' => [0x300a, 0x0280, 'SQ', '1'],
        'ChannelNumber' => [0x300a, 0x0282, 'IS', '1'],
        'ChannelLength' => [0x300a, 0x0284, 'DS', '1'],
        'ChannelTotalTime' => [0x300a, 0x0286, 'DS', '1'],
        'SourceMovementType' => [0x300a, 0x0288, 'CS', '1'],
        'NumberOfPulses' => [0x300a, 0x028a, 'IS', '1'],
        'PulseRepetitionInterval' => [0x300a, 0x028c, 'DS', '1'],
        'SourceApplicatorNumber' => [0x300a, 0x0290, 'IS', '1'],
        'SourceApplicatorID' => [0x300a, 0x0291, 'SH', '1'],
        'SourceApplicatorType' => [0x300a, 0x0292, 'CS', '1'],
        'SourceApplicatorName' => [0x300a, 0x0294, 'LO', '1'],
        'SourceApplicatorLength' => [0x300a, 0x0296, 'DS', '1'],
        'SourceApplicatorManufacturer' => [0x300a, 0x0298, 'LO', '1'],
        'SourceApplicatorWallNominalThickness' => [0x300a, 0x029c, 'DS', '1'],
        'SourceApplicatorWallNominalTransmission' => [0x300a, 0x029e, 'DS', '1'],
        'SourceApplicatorStepSize' => [0x300a, 0x02a0, 'DS', '1'],
        'ApplicatorShapeReferencedROINumber' => [0x300a, 0x02a1, 'IS', '1'],
        'TransferTubeNumber' => [0x300a, 0x02a2, 'IS', '1'],
        'TransferTubeLength' => [0x300a, 0x02a4, 'DS', '1'],
        'ChannelShieldSequence' => [0x300a, 0x02b0, 'SQ', '1'],
        'ChannelShieldNumber' => [0x300a, 0x02b2, 'IS', '1'],
        'ChannelShieldID' => [0x300a, 0x02b3, 'SH', '1'],
        'ChannelShieldName' => [0x300a, 0x02b4, 'LO', '1'],
        'ChannelShieldNominalThickness' => [0x300a, 0x02b8, 'DS', '1'],
        'ChannelShieldNominalTransmission' => [0x300a, 0x02ba, 'DS', '1'],
        'FinalCumulativeTimeWeight' => [0x300a, 0x02c8, 'DS', '1'],
        'BrachyControlPointSequence' => [0x300a, 0x02d0, 'SQ', '1'],
        'ControlPointRelativePosition' => [0x300a, 0x02d2, 'DS', '1'],
        'ControlPoint3DPosition' => [0x300a, 0x02d4, 'DS', '3'],
        'CumulativeTimeWeight' => [0x300a, 0x02d6, 'DS', '1'],
        'CompensatorDivergence' => [0x300a, 0x02e0, 'CS', '1'],
        'CompensatorMountingPosition' => [0x300a, 0x02e1, 'CS', '1'],
        'SourceToCompensatorDistance' => [0x300a, 0x02e2, 'DS', '1-n'],
        'TotalCompensatorTrayWaterEquivalentThickness' => [0x300a, 0x02e3, 'FL', '1'],
        'IsocenterToCompensatorTrayDistance' => [0x300a, 0x02e4, 'FL', '1'],
        'CompensatorColumnOffset' => [0x300a, 0x02e5, 'FL', '1'],
        'IsocenterToCompensatorDistances' => [0x300a, 0x02e6, 'FL', '1-n'],
        'CompensatorRelativeStoppingPowerRatio' => [0x300a, 0x02e7, 'FL', '1'],
        'CompensatorMillingToolDiameter' => [0x300a, 0x02e8, 'FL', '1'],
        'IonRangeCompensatorSequence' => [0x300a, 0x02ea, 'SQ', '1'],
        'CompensatorDescription' => [0x300a, 0x02eb, 'LT', '1'],
        'CompensatorSurfaceRepresentationFlag' => [0x300a, 0x02ec, 'CS', '1'],
        'RadiationMassNumber' => [0x300a, 0x0302, 'IS', '1'],
        'RadiationAtomicNumber' => [0x300a, 0x0304, 'IS', '1'],
        'RadiationChargeState' => [0x300a, 0x0306, 'SS', '1'],
        'ScanMode' => [0x300a, 0x0308, 'CS', '1'],
        'ModulatedScanModeType' => [0x300a, 0x0309, 'CS', '1'],
        'VirtualSourceAxisDistances' => [0x300a, 0x030a, 'FL', '2'],
        'SnoutSequence' => [0x300a, 0x030c, 'SQ', '1'],
        'SnoutPosition' => [0x300a, 0x030d, 'FL', '1'],
        'SnoutID' => [0x300a, 0x030f, 'SH', '1'],
        'NumberOfRangeShifters' => [0x300a, 0x0312, 'IS', '1'],
        'RangeShifterSequence' => [0x300a, 0x0314, 'SQ', '1'],
        'RangeShifterNumber' => [0x300a, 0x0316, 'IS', '1'],
        'RangeShifterID' => [0x300a, 0x0318, 'SH', '1'],
        'RangeShifterType' => [0x300a, 0x0320, 'CS', '1'],
        'RangeShifterDescription' => [0x300a, 0x0322, 'LO', '1'],
        'NumberOfLateralSpreadingDevices' => [0x300a, 0x0330, 'IS', '1'],
        'LateralSpreadingDeviceSequence' => [0x300a, 0x0332, 'SQ', '1'],
        'LateralSpreadingDeviceNumber' => [0x300a, 0x0334, 'IS', '1'],
        'LateralSpreadingDeviceID' => [0x300a, 0x0336, 'SH', '1'],
        'LateralSpreadingDeviceType' => [0x300a, 0x0338, 'CS', '1'],
        'LateralSpreadingDeviceDescription' => [0x300a, 0x033a, 'LO', '1'],
        'LateralSpreadingDeviceWaterEquivalentThickness' => [0x300a, 0x033c, 'FL', '1'],
        'NumberOfRangeModulators' => [0x300a, 0x0340, 'IS', '1'],
        'RangeModulatorSequence' => [0x300a, 0x0342, 'SQ', '1'],
        'RangeModulatorNumber' => [0x300a, 0x0344, 'IS', '1'],
        'RangeModulatorID' => [0x300a, 0x0346, 'SH', '1'],
        'RangeModulatorType' => [0x300a, 0x0348, 'CS', '1'],
        'RangeModulatorDescription' => [0x300a, 0x034a, 'LO', '1'],
        'BeamCurrentModulationID' => [0x300a, 0x034c, 'SH', '1'],
        'PatientSupportType' => [0x300a, 0x0350, 'CS', '1'],
        'PatientSupportID' => [0x300a, 0x0352, 'SH', '1'],
        'PatientSupportAccessoryCode' => [0x300a, 0x0354, 'LO', '1'],
        'TrayAccessoryCode' => [0x300a, 0x0355, 'LO', '1'],
        'FixationLightAzimuthalAngle' => [0x300a, 0x0356, 'FL', '1'],
        'FixationLightPolarAngle' => [0x300a, 0x0358, 'FL', '1'],
        'MetersetRate' => [0x300a, 0x035a, 'FL', '1'],
        'RangeShifterSettingsSequence' => [0x300a, 0x0360, 'SQ', '1'],
        'RangeShifterSetting' => [0x300a, 0x0362, 'LO', '1'],
        'IsocenterToRangeShifterDistance' => [0x300a, 0x0364, 'FL', '1'],
        'RangeShifterWaterEquivalentThickness' => [0x300a, 0x0366, 'FL', '1'],
        'LateralSpreadingDeviceSettingsSequence' => [0x300a, 0x0370, 'SQ', '1'],
        'LateralSpreadingDeviceSetting' => [0x300a, 0x0372, 'LO', '1'],
        'IsocenterToLateralSpreadingDeviceDistance' => [0x300a, 0x0374, 'FL', '1'],
        'RangeModulatorSettingsSequence' => [0x300a, 0x0380, 'SQ', '1'],
        'RangeModulatorGatingStartValue' => [0x300a, 0x0382, 'FL', '1'],
        'RangeModulatorGatingStopValue' => [0x300a, 0x0384, 'FL', '1'],
        'RangeModulatorGatingStartWaterEquivalentThickness' => [0x300a, 0x0386, 'FL', '1'],
        'RangeModulatorGatingStopWaterEquivalentThickness' => [0x300a, 0x0388, 'FL', '1'],
        'IsocenterToRangeModulatorDistance' => [0x300a, 0x038a, 'FL', '1'],
        'ScanSpotTimeOffset' => [0x300a, 0x038f, 'FL', '1-n'],
        'ScanSpotTuneID' => [0x300a, 0x0390, 'SH', '1'],
        'ScanSpotPrescribedIndices' => [0x300a, 0x0391, 'IS', '1-n'],
        'NumberOfScanSpotPositions' => [0x300a, 0x0392, 'IS', '1'],
        'ScanSpotReordered' => [0x300a, 0x0393, 'CS', '1'],
        'ScanSpotPositionMap' => [0x300a, 0x0394, 'FL', '1-n'],
        'ScanSpotReorderingAllowed' => [0x300a, 0x0395, 'CS', '1'],
        'ScanSpotMetersetWeights' => [0x300a, 0x0396, 'FL', '1-n'],
        'ScanningSpotSize' => [0x300a, 0x0398, 'FL', '2'],
        'ScanSpotSizesDelivered' => [0x300a, 0x0399, 'FL', '2-2n'],
        'NumberOfPaintings' => [0x300a, 0x039a, 'IS', '1'],
        'ScanSpotGantryAngles' => [0x300a, 0x039b, 'FL', '1-n'],
        'ScanSpotPatientSupportAngles' => [0x300a, 0x039c, 'FL', '1-n'],
        'IonToleranceTableSequence' => [0x300a, 0x03a0, 'SQ', '1'],
        'IonBeamSequence' => [0x300a, 0x03a2, 'SQ', '1'],
        'IonBeamLimitingDeviceSequence' => [0x300a, 0x03a4, 'SQ', '1'],
        'IonBlockSequence' => [0x300a, 0x03a6, 'SQ', '1'],
        'IonControlPointSequence' => [0x300a, 0x03a8, 'SQ', '1'],
        'IonWedgeSequence' => [0x300a, 0x03aa, 'SQ', '1'],
        'IonWedgePositionSequence' => [0x300a, 0x03ac, 'SQ', '1'],
        'ReferencedSetupImageSequence' => [0x300a, 0x0401, 'SQ', '1'],
        'SetupImageComment' => [0x300a, 0x0402, 'ST', '1'],
        'MotionSynchronizationSequence' => [0x300a, 0x0410, 'SQ', '1'],
        'ControlPointOrientation' => [0x300a, 0x0412, 'FL', '3'],
        'GeneralAccessorySequence' => [0x300a, 0x0420, 'SQ', '1'],
        'GeneralAccessoryID' => [0x300a, 0x0421, 'SH', '1'],
        'GeneralAccessoryDescription' => [0x300a, 0x0422, 'ST', '1'],
        'GeneralAccessoryType' => [0x300a, 0x0423, 'CS', '1'],
        'GeneralAccessoryNumber' => [0x300a, 0x0424, 'IS', '1'],
        'SourceToGeneralAccessoryDistance' => [0x300a, 0x0425, 'FL', '1'],
        'IsocenterToGeneralAccessoryDistance' => [0x300a, 0x0426, 'DS', '1'],
        'ApplicatorGeometrySequence' => [0x300a, 0x0431, 'SQ', '1'],
        'ApplicatorApertureShape' => [0x300a, 0x0432, 'CS', '1'],
        'ApplicatorOpening' => [0x300a, 0x0433, 'FL', '1'],
        'ApplicatorOpeningX' => [0x300a, 0x0434, 'FL', '1'],
        'ApplicatorOpeningY' => [0x300a, 0x0435, 'FL', '1'],
        'SourceToApplicatorMountingPositionDistance' => [0x300a, 0x0436, 'FL', '1'],
        'NumberOfBlockSlabItems' => [0x300a, 0x0440, 'IS', '1'],
        'BlockSlabSequence' => [0x300a, 0x0441, 'SQ', '1'],
        'BlockSlabThickness' => [0x300a, 0x0442, 'DS', '1'],
        'BlockSlabNumber' => [0x300a, 0x0443, 'US', '1'],
        'DeviceMotionControlSequence' => [0x300a, 0x0450, 'SQ', '1'],
        'DeviceMotionExecutionMode' => [0x300a, 0x0451, 'CS', '1'],
        'DeviceMotionObservationMode' => [0x300a, 0x0452, 'CS', '1'],
        'DeviceMotionParameterCodeSequence' => [0x300a, 0x0453, 'SQ', '1'],
        'DistalDepthFraction' => [0x300a, 0x0501, 'FL', '1'],
        'DistalDepth' => [0x300a, 0x0502, 'FL', '1'],
        'NominalRangeModulationFractions' => [0x300a, 0x0503, 'FL', '2'],
        'NominalRangeModulatedRegionDepths' => [0x300a, 0x0504, 'FL', '2'],
        'DepthDoseParametersSequence' => [0x300a, 0x0505, 'SQ', '1'],
        'DeliveredDepthDoseParametersSequence' => [0x300a, 0x0506, 'SQ', '1'],
        'DeliveredDistalDepthFraction' => [0x300a, 0x0507, 'FL', '1'],
        'DeliveredDistalDepth' => [0x300a, 0x0508, 'FL', '1'],
        'DeliveredNominalRangeModulationFractions' => [0x300a, 0x0509, 'FL', '2'],
        'DeliveredNominalRangeModulatedRegionDepths' => [0x300a, 0x0510, 'FL', '2'],
        'DeliveredReferenceDoseDefinition' => [0x300a, 0x0511, 'CS', '1'],
        'ReferenceDoseDefinition' => [0x300a, 0x0512, 'CS', '1'],
        'RTControlPointIndex' => [0x300a, 0x0600, 'US', '1'],
        'RadiationGenerationModeIndex' => [0x300a, 0x0601, 'US', '1'],
        'ReferencedDefinedDeviceIndex' => [0x300a, 0x0602, 'US', '1'],
        'RadiationDoseIdentificationIndex' => [0x300a, 0x0603, 'US', '1'],
        'NumberOfRTControlPoints' => [0x300a, 0x0604, 'US', '1'],
        'ReferencedRadiationGenerationModeIndex' => [0x300a, 0x0605, 'US', '1'],
        'TreatmentPositionIndex' => [0x300a, 0x0606, 'US', '1'],
        'ReferencedDeviceIndex' => [0x300a, 0x0607, 'US', '1'],
        'TreatmentPositionGroupLabel' => [0x300a, 0x0608, 'LO', '1'],
        'TreatmentPositionGroupUID' => [0x300a, 0x0609, 'UI', '1'],
        'TreatmentPositionGroupSequence' => [0x300a, 0x060a, 'SQ', '1'],
        'ReferencedTreatmentPositionIndex' => [0x300a, 0x060b, 'US', '1'],
        'ReferencedRadiationDoseIdentificationIndex' => [0x300a, 0x060c, 'US', '1'],
        'RTAccessoryHolderWaterEquivalentThickness' => [0x300a, 0x060d, 'FD', '1'],
        'ReferencedRTAccessoryHolderDeviceIndex' => [0x300a, 0x060e, 'US', '1'],
        'RTAccessoryHolderSlotExistenceFlag' => [0x300a, 0x060f, 'CS', '1'],
        'RTAccessoryHolderSlotSequence' => [0x300a, 0x0610, 'SQ', '1'],
        'RTAccessoryHolderSlotID' => [0x300a, 0x0611, 'LO', '1'],
        'RTAccessoryHolderSlotDistance' => [0x300a, 0x0612, 'FD', '1'],
        'RTAccessorySlotDistance' => [0x300a, 0x0613, 'FD', '1'],
        'RTAccessoryHolderDefinitionSequence' => [0x300a, 0x0614, 'SQ', '1'],
        'RTAccessoryDeviceSlotID' => [0x300a, 0x0615, 'LO', '1'],
        'RTRadiationSequence' => [0x300a, 0x0616, 'SQ', '1'],
        'RadiationDoseSequence' => [0x300a, 0x0617, 'SQ', '1'],
        'RadiationDoseIdentificationSequence' => [0x300a, 0x0618, 'SQ', '1'],
        'RadiationDoseIdentificationLabel' => [0x300a, 0x0619, 'LO', '1'],
        'ReferenceDoseType' => [0x300a, 0x061a, 'CS', '1'],
        'PrimaryDoseValueIndicator' => [0x300a, 0x061b, 'CS', '1'],
        'DoseValuesSequence' => [0x300a, 0x061c, 'SQ', '1'],
        'DoseValuePurpose' => [0x300a, 0x061d, 'CS', '1-n'],
        'ReferenceDosePointCoordinates' => [0x300a, 0x061e, 'FD', '3'],
        'RadiationDoseValuesParametersSequence' => [0x300a, 0x061f, 'SQ', '1'],
        'MetersetToDoseMappingSequence' => [0x300a, 0x0620, 'SQ', '1'],
        'ExpectedInVivoMeasurementValuesSequence' => [0x300a, 0x0621, 'SQ', '1'],
        'ExpectedInVivoMeasurementValueIndex' => [0x300a, 0x0622, 'US', '1'],
        'RadiationDoseInVivoMeasurementLabel' => [0x300a, 0x0623, 'LO', '1'],
        'RadiationDoseCentralAxisDisplacement' => [0x300a, 0x0624, 'FD', '2'],
        'RadiationDoseValue' => [0x300a, 0x0625, 'FD', '1'],
        'RadiationDoseSourceToSkinDistance' => [0x300a, 0x0626, 'FD', '1'],
        'RadiationDoseMeasurementPointCoordinates' => [0x300a, 0x0627, 'FD', '3'],
        'RadiationDoseSourceToExternalContourDistance' => [0x300a, 0x0628, 'FD', '1'],
        'RTToleranceSetSequence' => [0x300a, 0x0629, 'SQ', '1'],
        'RTToleranceSetLabel' => [0x300a, 0x062a, 'LO', '1'],
        'AttributeToleranceValuesSequence' => [0x300a, 0x062b, 'SQ', '1'],
        'ToleranceValue' => [0x300a, 0x062c, 'FD', '1'],
        'PatientSupportPositionToleranceSequence' => [0x300a, 0x062d, 'SQ', '1'],
        'TreatmentTimeLimit' => [0x300a, 0x062e, 'FD', '1'],
        'CArmPhotonElectronControlPointSequence' => [0x300a, 0x062f, 'SQ', '1'],
        'ReferencedRTRadiationSequence' => [0x300a, 0x0630, 'SQ', '1'],
        'ReferencedRTInstanceSequence' => [0x300a, 0x0631, 'SQ', '1'],
        'SourceToPatientSurfaceDistance' => [0x300a, 0x0634, 'FD', '1'],
        'TreatmentMachineSpecialModeCodeSequence' => [0x300a, 0x0635, 'SQ', '1'],
        'IntendedNumberOfFractions' => [0x300a, 0x0636, 'US', '1'],
        'RTRadiationSetIntent' => [0x300a, 0x0637, 'CS', '1'],
        'RTRadiationPhysicalAndGeometricContentDetailFlag' => [0x300a, 0x0638, 'CS', '1'],
        'RTRecordFlag' => [0x300a, 0x0639, 'CS', '1'],
        'TreatmentDeviceIdentificationSequence' => [0x300a, 0x063a, 'SQ', '1'],
        'ReferencedRTPhysicianIntentSequence' => [0x300a, 0x063b, 'SQ', '1'],
        'CumulativeMeterset' => [0x300a, 0x063c, 'FD', '1'],
        'DeliveryRate' => [0x300a, 0x063d, 'FD', '1'],
        'DeliveryRateUnitSequence' => [0x300a, 0x063e, 'SQ', '1'],
        'TreatmentPositionSequence' => [0x300a, 0x063f, 'SQ', '1'],
        'RadiationSourceAxisDistance' => [0x300a, 0x0640, 'FD', '1'],
        'NumberOfRTBeamLimitingDevices' => [0x300a, 0x0641, 'US', '1'],
        'RTBeamLimitingDeviceProximalDistance' => [0x300a, 0x0642, 'FD', '1'],
        'RTBeamLimitingDeviceDistalDistance' => [0x300a, 0x0643, 'FD', '1'],
        'ParallelRTBeamDelimiterDeviceOrientationLabelCodeSequence' => [0x300a, 0x0644, 'SQ', '1'],
        'BeamModifierOrientationAngle' => [0x300a, 0x0645, 'FD', '1'],
        'FixedRTBeamDelimiterDeviceSequence' => [0x300a, 0x0646, 'SQ', '1'],
        'ParallelRTBeamDelimiterDeviceSequence' => [0x300a, 0x0647, 'SQ', '1'],
        'NumberOfParallelRTBeamDelimiters' => [0x300a, 0x0648, 'US', '1'],
        'ParallelRTBeamDelimiterBoundaries' => [0x300a, 0x0649, 'FD', '2-n'],
        'ParallelRTBeamDelimiterPositions' => [0x300a, 0x064a, 'FD', '2-n'],
        'RTBeamLimitingDeviceOffset' => [0x300a, 0x064b, 'FD', '2'],
        'RTBeamDelimiterGeometrySequence' => [0x300a, 0x064c, 'SQ', '1'],
        'RTBeamLimitingDeviceDefinitionSequence' => [0x300a, 0x064d, 'SQ', '1'],
        'ParallelRTBeamDelimiterOpeningMode' => [0x300a, 0x064e, 'CS', '1'],
        'ParallelRTBeamDelimiterLeafMountingSide' => [0x300a, 0x064f, 'CS', '1-n'],
        'WedgeDefinitionSequence' => [0x300a, 0x0651, 'SQ', '1'],
        'RadiationBeamWedgeAngle' => [0x300a, 0x0652, 'FD', '1'],
        'RadiationBeamWedgeThinEdgeDistance' => [0x300a, 0x0653, 'FD', '1'],
        'RadiationBeamEffectiveWedgeAngle' => [0x300a, 0x0654, 'FD', '1'],
        'NumberOfWedgePositions' => [0x300a, 0x0655, 'US', '1'],
        'RTBeamLimitingDeviceOpeningSequence' => [0x300a, 0x0656, 'SQ', '1'],
        'NumberOfRTBeamLimitingDeviceOpenings' => [0x300a, 0x0657, 'US', '1'],
        'RadiationDosimeterUnitSequence' => [0x300a, 0x0658, 'SQ', '1'],
        'RTDeviceDistanceReferenceLocationCodeSequence' => [0x300a, 0x0659, 'SQ', '1'],
        'RadiationDeviceConfigurationAndCommissioningKeySequence' => [0x300a, 0x065a, 'SQ', '1'],
        'PatientSupportPositionParameterSequence' => [0x300a, 0x065b, 'SQ', '1'],
        'PatientSupportPositionSpecificationMethod' => [0x300a, 0x065c, 'CS', '1'],
        'PatientSupportPositionDeviceParameterSequence' => [0x300a, 0x065d, 'SQ', '1'],
        'DeviceOrderIndex' => [0x300a, 0x065e, 'US', '1'],
        'PatientSupportPositionParameterOrderIndex' => [0x300a, 0x065f, 'US', '1'],
        'PatientSupportPositionDeviceToleranceSequence' => [0x300a, 0x0660, 'SQ', '1'],
        'PatientSupportPositionToleranceOrderIndex' => [0x300a, 0x0661, 'US', '1'],
        'CompensatorDefinitionSequence' => [0x300a, 0x0662, 'SQ', '1'],
        'CompensatorMapOrientation' => [0x300a, 0x0663, 'CS', '1'],
        'CompensatorProximalThicknessMap' => [0x300a, 0x0664, 'OF', '1'],
        'CompensatorDistalThicknessMap' => [0x300a, 0x0665, 'OF', '1'],
        'CompensatorBasePlaneOffset' => [0x300a, 0x0666, 'FD', '1'],
        'CompensatorShapeFabricationCodeSequence' => [0x300a, 0x0667, 'SQ', '1'],
        'CompensatorShapeSequence' => [0x300a, 0x0668, 'SQ', '1'],
        'RadiationBeamCompensatorMillingToolDiameter' => [0x300a, 0x0669, 'FD', '1'],
        'BlockDefinitionSequence' => [0x300a, 0x066a, 'SQ', '1'],
        'BlockEdgeData' => [0x300a, 0x066b, 'OF', '1'],
        'BlockOrientation' => [0x300a, 0x066c, 'CS', '1'],
        'RadiationBeamBlockThickness' => [0x300a, 0x066d, 'FD', '1'],
        'RadiationBeamBlockSlabThickness' => [0x300a, 0x066e, 'FD', '1'],
        'BlockEdgeDataSequence' => [0x300a, 0x066f, 'SQ', '1'],
        'NumberOfRTAccessoryHolders' => [0x300a, 0x0670, 'US', '1'],
        'GeneralAccessoryDefinitionSequence' => [0x300a, 0x0671, 'SQ', '1'],
        'NumberOfGeneralAccessories' => [0x300a, 0x0672, 'US', '1'],
        'BolusDefinitionSequence' => [0x300a, 0x0673, 'SQ', '1'],
        'NumberOfBoluses' => [0x300a, 0x0674, 'US', '1'],
        'EquipmentFrameOfReferenceUID' => [0x300a, 0x0675, 'UI', '1'],
        'EquipmentFrameOfReferenceDescription' => [0x300a, 0x0676, 'ST', '1'],
        'EquipmentReferencePointCoordinatesSequence' => [0x300a, 0x0677, 'SQ', '1'],
        'EquipmentReferencePointCodeSequence' => [0x300a, 0x0678, 'SQ', '1'],
        'RTBeamLimitingDeviceAngle' => [0x300a, 0x0679, 'FD', '1'],
        'SourceRollAngle' => [0x300a, 0x067a, 'FD', '1'],
        'RadiationGenerationModeSequence' => [0x300a, 0x067b, 'SQ', '1'],
        'RadiationGenerationModeLabel' => [0x300a, 0x067c, 'SH', '1'],
        'RadiationGenerationModeDescription' => [0x300a, 0x067d, 'ST', '1'],
        'RadiationGenerationModeMachineCodeSequence' => [0x300a, 0x067e, 'SQ', '1'],
        'RadiationTypeCodeSequence' => [0x300a, 0x067f, 'SQ', '1'],
        'NominalEnergy' => [0x300a, 0x0680, 'DS', '1'],
        'MinimumNominalEnergy' => [0x300a, 0x0681, 'DS', '1'],
        'MaximumNominalEnergy' => [0x300a, 0x0682, 'DS', '1'],
        'RadiationFluenceModifierCodeSequence' => [0x300a, 0x0683, 'SQ', '1'],
        'EnergyUnitCodeSequence' => [0x300a, 0x0684, 'SQ', '1'],
        'NumberOfRadiationGenerationModes' => [0x300a, 0x0685, 'US', '1'],
        'PatientSupportDevicesSequence' => [0x300a, 0x0686, 'SQ', '1'],
        'NumberOfPatientSupportDevices' => [0x300a, 0x0687, 'US', '1'],
        'RTBeamModifierDefinitionDistance' => [0x300a, 0x0688, 'FD', '1'],
        'BeamAreaLimitSequence' => [0x300a, 0x0689, 'SQ', '1'],
        'ReferencedRTPrescriptionSequence' => [0x300a, 0x068a, 'SQ', '1'],
        'DoseValueInterpretation' => [0x300a, 0x068b, 'CS', '1'],
        'TreatmentSessionUID' => [0x300a, 0x0700, 'UI', '1'],
        'RTRadiationUsage' => [0x300a, 0x0701, 'CS', '1'],
        'ReferencedRTRadiationSetSequence' => [0x300a, 0x0702, 'SQ', '1'],
        'ReferencedRTRadiationRecordSequence' => [0x300a, 0x0703, 'SQ', '1'],
        'RTRadiationSetDeliveryNumber' => [0x300a, 0x0704, 'US', '1'],
        'ClinicalFractionNumber' => [0x300a, 0x0705, 'US', '1'],
        'RTTreatmentFractionCompletionStatus' => [0x300a, 0x0706, 'CS', '1'],
        'RTRadiationSetUsage' => [0x300a, 0x0707, 'CS', '1'],
        'TreatmentDeliveryContinuationFlag' => [0x300a, 0x0708, 'CS', '1'],
        'TreatmentRecordContentOrigin' => [0x300a, 0x0709, 'CS', '1'],
        'RTTreatmentTerminationStatus' => [0x300a, 0x0714, 'CS', '1'],
        'RTTreatmentTerminationReasonCodeSequence' => [0x300a, 0x0715, 'SQ', '1'],
        'MachineSpecificTreatmentTerminationCodeSequence' => [0x300a, 0x0716, 'SQ', '1'],
        'RTRadiationSalvageRecordControlPointSequence' => [0x300a, 0x0722, 'SQ', '1'],
        'StartingMetersetValueKnownFlag' => [0x300a, 0x0723, 'CS', '1'],
        'TreatmentTerminationDescription' => [0x300a, 0x0730, 'ST', '1'],
        'TreatmentToleranceViolationSequence' => [0x300a, 0x0731, 'SQ', '1'],
        'TreatmentToleranceViolationCategory' => [0x300a, 0x0732, 'CS', '1'],
        'TreatmentToleranceViolationAttributeSequence' => [0x300a, 0x0733, 'SQ', '1'],
        'TreatmentToleranceViolationDescription' => [0x300a, 0x0734, 'ST', '1'],
        'TreatmentToleranceViolationIdentification' => [0x300a, 0x0735, 'ST', '1'],
        'TreatmentToleranceViolationDateTime' => [0x300a, 0x0736, 'DT', '1'],
        'RecordedRTControlPointDateTime' => [0x300a, 0x073a, 'DT', '1'],
        'ReferencedRadiationRTControlPointIndex' => [0x300a, 0x073b, 'US', '1'],
        'AlternateValueSequence' => [0x300a, 0x073e, 'SQ', '1'],
        'ConfirmationSequence' => [0x300a, 0x073f, 'SQ', '1'],
        'InterlockSequence' => [0x300a, 0x0740, 'SQ', '1'],
        'InterlockDateTime' => [0x300a, 0x0741, 'DT', '1'],
        'InterlockDescription' => [0x300a, 0x0742, 'ST', '1'],
        'InterlockOriginatingDeviceSequence' => [0x300a, 0x0743, 'SQ', '1'],
        'InterlockCodeSequence' => [0x300a, 0x0744, 'SQ', '1'],
        'InterlockResolutionCodeSequence' => [0x300a, 0x0745, 'SQ', '1'],
        'InterlockResolutionUserSequence' => [0x300a, 0x0746, 'SQ', '1'],
        'OverrideDateTime' => [0x300a, 0x0760, 'DT', '1'],
        'TreatmentToleranceViolationTypeCodeSequence' => [0x300a, 0x0761, 'SQ', '1'],
        'TreatmentToleranceViolationCauseCodeSequence' => [0x300a, 0x0762, 'SQ', '1'],
        'MeasuredMetersetToDoseMappingSequence' => [0x300a, 0x0772, 'SQ', '1'],
        'ReferencedExpectedInVivoMeasurementValueIndex' => [0x300a, 0x0773, 'US', '1'],
        'DoseMeasurementDeviceCodeSequence' => [0x300a, 0x0774, 'SQ', '1'],
        'AdditionalParameterRecordingInstanceSequence' => [0x300a, 0x0780, 'SQ', '1'],
        'InterlockOriginDescription' => [0x300a, 0x0783, 'ST', '1'],
        'RTPatientPositionScopeSequence' => [0x300a, 0x0784, 'SQ', '1'],
        'ReferencedTreatmentPositionGroupUID' => [0x300a, 0x0785, 'UI', '1'],
        'RadiationOrderIndex' => [0x300a, 0x0786, 'US', '1'],
        'OmittedRadiationSequence' => [0x300a, 0x0787, 'SQ', '1'],
        'ReasonForOmissionCodeSequence' => [0x300a, 0x0788, 'SQ', '1'],
        'RTDeliveryStartPatientPositionSequence' => [0x300a, 0x0789, 'SQ', '1'],
        'RTTreatmentPreparationPatientPositionSequence' => [0x300a, 0x078a, 'SQ', '1'],
        'ReferencedRTTreatmentPreparationSequence' => [0x300a, 0x078b, 'SQ', '1'],
        'ReferencedPatientSetupPhotoSequence' => [0x300a, 0x078c, 'SQ', '1'],
        'PatientTreatmentPreparationMethodCodeSequence' => [0x300a, 0x078d, 'SQ', '1'],
        'PatientTreatmentPreparationProcedureParameterDescription' => [0x300a, 0x078e, 'LT', '1'],
        'PatientTreatmentPreparationDeviceSequence' => [0x300a, 0x078f, 'SQ', '1'],
        'PatientTreatmentPreparationProcedureSequence' => [0x300a, 0x0790, 'SQ', '1'],
        'PatientTreatmentPreparationProcedureCodeSequence' => [0x300a, 0x0791, 'SQ', '1'],
        'PatientTreatmentPreparationMethodDescription' => [0x300a, 0x0792, 'LT', '1'],
        'PatientTreatmentPreparationProcedureParameterSequence' => [0x300a, 0x0793, 'SQ', '1'],
        'PatientSetupPhotoDescription' => [0x300a, 0x0794, 'LT', '1'],
        'PatientTreatmentPreparationProcedureIndex' => [0x300a, 0x0795, 'US', '1'],
        'ReferencedPatientSetupProcedureIndex' => [0x300a, 0x0796, 'US', '1'],
        'RTRadiationTaskSequence' => [0x300a, 0x0797, 'SQ', '1'],
        'RTPatientPositionDisplacementSequence' => [0x300a, 0x0798, 'SQ', '1'],
        'RTPatientPositionSequence' => [0x300a, 0x0799, 'SQ', '1'],
        'DisplacementReferenceLabel' => [0x300a, 0x079a, 'LO', '1'],
        'DisplacementMatrix' => [0x300a, 0x079b, 'FD', '16'],
        'PatientSupportDisplacementSequence' => [0x300a, 0x079c, 'SQ', '1'],
        'DisplacementReferenceLocationCodeSequence' => [0x300a, 0x079d, 'SQ', '1'],
        'RTRadiationSetDeliveryUsage' => [0x300a, 0x079e, 'CS', '1'],
        'PatientTreatmentPreparationSequence' => [0x300a, 0x079f, 'SQ', '1'],
        'PatientToEquipmentRelationshipSequence' => [0x300a, 0x07a0, 'SQ', '1'],
        'ImagingEquipmentToTreatmentDeliveryDeviceRelationshipSequence' => [0x300a, 0x07a1, 'SQ', '1'],
        'ReferencedRTPlanSequence' => [0x300c, 0x0002, 'SQ', '1'],
        'ReferencedBeamSequence' => [0x300c, 0x0004, 'SQ', '1'],
        'ReferencedBeamNumber' => [0x300c, 0x0006, 'IS', '1'],
        'ReferencedReferenceImageNumber' => [0x300c, 0x0007, 'IS', '1'],
        'StartCumulativeMetersetWeight' => [0x300c, 0x0008, 'DS', '1'],
        'EndCumulativeMetersetWeight' => [0x300c, 0x0009, 'DS', '1'],
        'ReferencedBrachyApplicationSetupSequence' => [0x300c, 0x000a, 'SQ', '1'],
        'ReferencedBrachyApplicationSetupNumber' => [0x300c, 0x000c, 'IS', '1'],
        'ReferencedSourceNumber' => [0x300c, 0x000e, 'IS', '1'],
        'ReferencedFractionGroupSequence' => [0x300c, 0x0020, 'SQ', '1'],
        'ReferencedFractionGroupNumber' => [0x300c, 0x0022, 'IS', '1'],
        'ReferencedVerificationImageSequence' => [0x300c, 0x0040, 'SQ', '1'],
        'ReferencedReferenceImageSequence' => [0x300c, 0x0042, 'SQ', '1'],
        'ReferencedDoseReferenceSequence' => [0x300c, 0x0050, 'SQ', '1'],
        'ReferencedDoseReferenceNumber' => [0x300c, 0x0051, 'IS', '1'],
        'BrachyReferencedDoseReferenceSequence' => [0x300c, 0x0055, 'SQ', '1'],
        'ReferencedStructureSetSequence' => [0x300c, 0x0060, 'SQ', '1'],
        'ReferencedPatientSetupNumber' => [0x300c, 0x006a, 'IS', '1'],
        'ReferencedDoseSequence' => [0x300c, 0x0080, 'SQ', '1'],
        'ReferencedToleranceTableNumber' => [0x300c, 0x00a0, 'IS', '1'],
        'ReferencedBolusSequence' => [0x300c, 0x00b0, 'SQ', '1'],
        'ReferencedWedgeNumber' => [0x300c, 0x00c0, 'IS', '1'],
        'ReferencedCompensatorNumber' => [0x300c, 0x00d0, 'IS', '1'],
        'ReferencedBlockNumber' => [0x300c, 0x00e0, 'IS', '1'],
        'ReferencedControlPointIndex' => [0x300c, 0x00f0, 'IS', '1'],
        'ReferencedControlPointSequence' => [0x300c, 0x00f2, 'SQ', '1'],
        'ReferencedStartControlPointIndex' => [0x300c, 0x00f4, 'IS', '1'],
        'ReferencedStopControlPointIndex' => [0x300c, 0x00f6, 'IS', '1'],
        'ReferencedRangeShifterNumber' => [0x300c, 0x0100, 'IS', '1'],
        'ReferencedLateralSpreadingDeviceNumber' => [0x300c, 0x0102, 'IS', '1'],
        'ReferencedRangeModulatorNumber' => [0x300c, 0x0104, 'IS', '1'],
        'OmittedBeamTaskSequence' => [0x300c, 0x0111, 'SQ', '1'],
        'ReasonForOmission' => [0x300c, 0x0112, 'CS', '1'],
        'ReasonForOmissionDescription' => [0x300c, 0x0113, 'LO', '1'],
        'PrescriptionOverviewSequence' => [0x300c, 0x0114, 'SQ', '1'],
        'TotalPrescriptionDose' => [0x300c, 0x0115, 'FL', '1'],
        'PlanOverviewSequence' => [0x300c, 0x0116, 'SQ', '1'],
        'PlanOverviewIndex' => [0x300c, 0x0117, 'US', '1'],
        'ReferencedPlanOverviewIndex' => [0x300c, 0x0118, 'US', '1'],
        'NumberOfFractionsIncluded' => [0x300c, 0x0119, 'US', '1'],
        'DoseCalibrationConditionsSequence' => [0x300c, 0x0120, 'SQ', '1'],
        'AbsorbedDoseToMetersetRatio' => [0x300c, 0x0121, 'FD', '1'],
        'DelineatedRadiationFieldSize' => [0x300c, 0x0122, 'FD', '2'],
        'DoseCalibrationConditionsVerifiedFlag' => [0x300c, 0x0123, 'CS', '1'],
        'CalibrationReferencePointDepth' => [0x300c, 0x0124, 'FD', '1'],
        'GatingBeamHoldTransitionSequence' => [0x300c, 0x0125, 'SQ', '1'],
        'BeamHoldTransition' => [0x300c, 0x0126, 'CS', '1'],
        'BeamHoldTransitionDateTime' => [0x300c, 0x0127, 'DT', '1'],
        'BeamHoldOriginatingDeviceSequence' => [0x300c, 0x0128, 'SQ', '1'],
        'BeamHoldTransitionTriggerSource' => [0x300c, 0x0129, 'CS', '1'],
        'ApprovalStatus' => [0x300e, 0x0002, 'CS', '1'],
        'ReviewDate' => [0x300e, 0x0004, 'DA', '1'],
        'ReviewTime' => [0x300e, 0x0005, 'TM', '1'],
        'ReviewerName' => [0x300e, 0x0008, 'PN', '1'],
        'RadiobiologicalDoseEffectSequence' => [0x3010, 0x0001, 'SQ', '1'],
        'RadiobiologicalDoseEffectFlag' => [0x3010, 0x0002, 'CS', '1'],
        'EffectiveDoseCalculationMethodCategoryCodeSequence' => [0x3010, 0x0003, 'SQ', '1'],
        'EffectiveDoseCalculationMethodCodeSequence' => [0x3010, 0x0004, 'SQ', '1'],
        'EffectiveDoseCalculationMethodDescription' => [0x3010, 0x0005, 'LO', '1'],
        'ConceptualVolumeUID' => [0x3010, 0x0006, 'UI', '1'],
        'OriginatingSOPInstanceReferenceSequence' => [0x3010, 0x0007, 'SQ', '1'],
        'ConceptualVolumeConstituentSequence' => [0x3010, 0x0008, 'SQ', '1'],
        'EquivalentConceptualVolumeInstanceReferenceSequence' => [0x3010, 0x0009, 'SQ', '1'],
        'EquivalentConceptualVolumesSequence' => [0x3010, 0x000a, 'SQ', '1'],
        'ReferencedConceptualVolumeUID' => [0x3010, 0x000b, 'UI', '1'],
        'ConceptualVolumeCombinationExpression' => [0x3010, 0x000c, 'UT', '1'],
        'ConceptualVolumeConstituentIndex' => [0x3010, 0x000d, 'US', '1'],
        'ConceptualVolumeCombinationFlag' => [0x3010, 0x000e, 'CS', '1'],
        'ConceptualVolumeCombinationDescription' => [0x3010, 0x000f, 'ST', '1'],
        'ConceptualVolumeSegmentationDefinedFlag' => [0x3010, 0x0010, 'CS', '1'],
        'ConceptualVolumeSegmentationReferenceSequence' => [0x3010, 0x0011, 'SQ', '1'],
        'ConceptualVolumeConstituentSegmentationReferenceSequence' => [0x3010, 0x0012, 'SQ', '1'],
        'ConstituentConceptualVolumeUID' => [0x3010, 0x0013, 'UI', '1'],
        'DerivationConceptualVolumeSequence' => [0x3010, 0x0014, 'SQ', '1'],
        'SourceConceptualVolumeUID' => [0x3010, 0x0015, 'UI', '1'],
        'ConceptualVolumeDerivationAlgorithmSequence' => [0x3010, 0x0016, 'SQ', '1'],
        'ConceptualVolumeDescription' => [0x3010, 0x0017, 'ST', '1'],
        'SourceConceptualVolumeSequence' => [0x3010, 0x0018, 'SQ', '1'],
        'AuthorIdentificationSequence' => [0x3010, 0x0019, 'SQ', '1'],
        'ManufacturerModelVersion' => [0x3010, 0x001a, 'LO', '1'],
        'DeviceAlternateIdentifier' => [0x3010, 0x001b, 'UC', '1'],
        'DeviceAlternateIdentifierType' => [0x3010, 0x001c, 'CS', '1'],
        'DeviceAlternateIdentifierFormat' => [0x3010, 0x001d, 'LT', '1'],
        'SegmentationCreationTemplateLabel' => [0x3010, 0x001e, 'LO', '1'],
        'SegmentationTemplateUID' => [0x3010, 0x001f, 'UI', '1'],
        'ReferencedSegmentReferenceIndex' => [0x3010, 0x0020, 'US', '1'],
        'SegmentReferenceSequence' => [0x3010, 0x0021, 'SQ', '1'],
        'SegmentReferenceIndex' => [0x3010, 0x0022, 'US', '1'],
        'DirectSegmentReferenceSequence' => [0x3010, 0x0023, 'SQ', '1'],
        'CombinationSegmentReferenceSequence' => [0x3010, 0x0024, 'SQ', '1'],
        'ConceptualVolumeSequence' => [0x3010, 0x0025, 'SQ', '1'],
        'SegmentedRTAccessoryDeviceSequence' => [0x3010, 0x0026, 'SQ', '1'],
        'SegmentCharacteristicsSequence' => [0x3010, 0x0027, 'SQ', '1'],
        'RelatedSegmentCharacteristicsSequence' => [0x3010, 0x0028, 'SQ', '1'],
        'SegmentCharacteristicsPrecedence' => [0x3010, 0x0029, 'US', '1'],
        'RTSegmentAnnotationSequence' => [0x3010, 0x002a, 'SQ', '1'],
        'SegmentAnnotationCategoryCodeSequence' => [0x3010, 0x002b, 'SQ', '1'],
        'SegmentAnnotationTypeCodeSequence' => [0x3010, 0x002c, 'SQ', '1'],
        'DeviceLabel' => [0x3010, 0x002d, 'LO', '1'],
        'DeviceTypeCodeSequence' => [0x3010, 0x002e, 'SQ', '1'],
        'SegmentAnnotationTypeModifierCodeSequence' => [0x3010, 0x002f, 'SQ', '1'],
        'PatientEquipmentRelationshipCodeSequence' => [0x3010, 0x0030, 'SQ', '1'],
        'ReferencedFiducialsUID' => [0x3010, 0x0031, 'UI', '1'],
        'PatientTreatmentOrientationSequence' => [0x3010, 0x0032, 'SQ', '1'],
        'UserContentLabel' => [0x3010, 0x0033, 'SH', '1'],
        'UserContentLongLabel' => [0x3010, 0x0034, 'LO', '1'],
        'EntityLabel' => [0x3010, 0x0035, 'SH', '1'],
        'EntityName' => [0x3010, 0x0036, 'LO', '1'],
        'EntityDescription' => [0x3010, 0x0037, 'ST', '1'],
        'EntityLongLabel' => [0x3010, 0x0038, 'LO', '1'],
        'DeviceIndex' => [0x3010, 0x0039, 'US', '1'],
        'RTTreatmentPhaseIndex' => [0x3010, 0x003a, 'US', '1'],
        'RTTreatmentPhaseUID' => [0x3010, 0x003b, 'UI', '1'],
        'RTPrescriptionIndex' => [0x3010, 0x003c, 'US', '1'],
        'RTSegmentAnnotationIndex' => [0x3010, 0x003d, 'US', '1'],
        'BasisRTTreatmentPhaseIndex' => [0x3010, 0x003e, 'US', '1'],
        'RelatedRTTreatmentPhaseIndex' => [0x3010, 0x003f, 'US', '1'],
        'ReferencedRTTreatmentPhaseIndex' => [0x3010, 0x0040, 'US', '1'],
        'ReferencedRTPrescriptionIndex' => [0x3010, 0x0041, 'US', '1'],
        'ReferencedParentRTPrescriptionIndex' => [0x3010, 0x0042, 'US', '1'],
        'ManufacturerDeviceIdentifier' => [0x3010, 0x0043, 'ST', '1'],
        'InstanceLevelReferencedPerformedProcedureStepSequence' => [0x3010, 0x0044, 'SQ', '1'],
        'RTTreatmentPhaseIntentPresenceFlag' => [0x3010, 0x0045, 'CS', '1'],
        'RadiotherapyTreatmentType' => [0x3010, 0x0046, 'CS', '1'],
        'TeletherapyRadiationType' => [0x3010, 0x0047, 'CS', '1-n'],
        'BrachytherapySourceType' => [0x3010, 0x0048, 'CS', '1-n'],
        'ReferencedRTTreatmentPhaseSequence' => [0x3010, 0x0049, 'SQ', '1'],
        'ReferencedDirectSegmentInstanceSequence' => [0x3010, 0x004a, 'SQ', '1'],
        'IntendedRTTreatmentPhaseSequence' => [0x3010, 0x004b, 'SQ', '1'],
        'IntendedPhaseStartDate' => [0x3010, 0x004c, 'DA', '1'],
        'IntendedPhaseEndDate' => [0x3010, 0x004d, 'DA', '1'],
        'RTTreatmentPhaseIntervalSequence' => [0x3010, 0x004e, 'SQ', '1'],
        'TemporalRelationshipIntervalAnchor' => [0x3010, 0x004f, 'CS', '1'],
        'MinimumNumberOfIntervalDays' => [0x3010, 0x0050, 'FD', '1'],
        'MaximumNumberOfIntervalDays' => [0x3010, 0x0051, 'FD', '1'],
        'PertinentSOPClassesInStudy' => [0x3010, 0x0052, 'UI', '1-n'],
        'PertinentSOPClassesInSeries' => [0x3010, 0x0053, 'UI', '1-n'],
        'RTPrescriptionLabel' => [0x3010, 0x0054, 'LO', '1'],
        'RTPhysicianIntentPredecessorSequence' => [0x3010, 0x0055, 'SQ', '1'],
        'RTTreatmentApproachLabel' => [0x3010, 0x0056, 'LO', '1'],
        'RTPhysicianIntentSequence' => [0x3010, 0x0057, 'SQ', '1'],
        'RTPhysicianIntentIndex' => [0x3010, 0x0058, 'US', '1'],
        'RTTreatmentIntentType' => [0x3010, 0x0059, 'CS', '1'],
        'RTPhysicianIntentNarrative' => [0x3010, 0x005a, 'UT', '1'],
        'RTProtocolCodeSequence' => [0x3010, 0x005b, 'SQ', '1'],
        'ReasonForSuperseding' => [0x3010, 0x005c, 'ST', '1'],
        'RTDiagnosisCodeSequence' => [0x3010, 0x005d, 'SQ', '1'],
        'ReferencedRTPhysicianIntentIndex' => [0x3010, 0x005e, 'US', '1'],
        'RTPhysicianIntentInputInstanceSequence' => [0x3010, 0x005f, 'SQ', '1'],
        'RTAnatomicPrescriptionSequence' => [0x3010, 0x0060, 'SQ', '1'],
        'PriorTreatmentDoseDescription' => [0x3010, 0x0061, 'UT', '1'],
        'PriorTreatmentReferenceSequence' => [0x3010, 0x0062, 'SQ', '1'],
        'DosimetricObjectiveEvaluationScope' => [0x3010, 0x0063, 'CS', '1'],
        'TherapeuticRoleCategoryCodeSequence' => [0x3010, 0x0064, 'SQ', '1'],
        'TherapeuticRoleTypeCodeSequence' => [0x3010, 0x0065, 'SQ', '1'],
        'ConceptualVolumeOptimizationPrecedence' => [0x3010, 0x0066, 'US', '1'],
        'ConceptualVolumeCategoryCodeSequence' => [0x3010, 0x0067, 'SQ', '1'],
        'ConceptualVolumeBlockingConstraint' => [0x3010, 0x0068, 'CS', '1'],
        'ConceptualVolumeTypeCodeSequence' => [0x3010, 0x0069, 'SQ', '1'],
        'ConceptualVolumeTypeModifierCodeSequence' => [0x3010, 0x006a, 'SQ', '1'],
        'RTPrescriptionSequence' => [0x3010, 0x006b, 'SQ', '1'],
        'DosimetricObjectiveSequence' => [0x3010, 0x006c, 'SQ', '1'],
        'DosimetricObjectiveTypeCodeSequence' => [0x3010, 0x006d, 'SQ', '1'],
        'DosimetricObjectiveUID' => [0x3010, 0x006e, 'UI', '1'],
        'ReferencedDosimetricObjectiveUID' => [0x3010, 0x006f, 'UI', '1'],
        'DosimetricObjectiveParameterSequence' => [0x3010, 0x0070, 'SQ', '1'],
        'ReferencedDosimetricObjectivesSequence' => [0x3010, 0x0071, 'SQ', '1'],
        'AbsoluteDosimetricObjectiveFlag' => [0x3010, 0x0073, 'CS', '1'],
        'DosimetricObjectiveWeight' => [0x3010, 0x0074, 'FD', '1'],
        'DosimetricObjectivePurpose' => [0x3010, 0x0075, 'CS', '1'],
        'PlanningInputInformationSequence' => [0x3010, 0x0076, 'SQ', '1'],
        'TreatmentSite' => [0x3010, 0x0077, 'LO', '1'],
        'TreatmentSiteCodeSequence' => [0x3010, 0x0078, 'SQ', '1'],
        'FractionPatternSequence' => [0x3010, 0x0079, 'SQ', '1'],
        'TreatmentTechniqueNotes' => [0x3010, 0x007a, 'UT', '1'],
        'PrescriptionNotes' => [0x3010, 0x007b, 'UT', '1'],
        'NumberOfIntervalFractions' => [0x3010, 0x007c, 'IS', '1'],
        'NumberOfFractions' => [0x3010, 0x007d, 'US', '1'],
        'IntendedDeliveryDuration' => [0x3010, 0x007e, 'US', '1'],
        'FractionationNotes' => [0x3010, 0x007f, 'UT', '1'],
        'RTTreatmentTechniqueCodeSequence' => [0x3010, 0x0080, 'SQ', '1'],
        'PrescriptionNotesSequence' => [0x3010, 0x0081, 'SQ', '1'],
        'FractionBasedRelationshipSequence' => [0x3010, 0x0082, 'SQ', '1'],
        'FractionBasedRelationshipIntervalAnchor' => [0x3010, 0x0083, 'CS', '1'],
        'MinimumHoursBetweenFractions' => [0x3010, 0x0084, 'FD', '1'],
        'IntendedFractionStartTime' => [0x3010, 0x0085, 'TM', '1-n'],
        'IntendedStartDayOfWeek' => [0x3010, 0x0086, 'LT', '1'],
        'WeekdayFractionPatternSequence' => [0x3010, 0x0087, 'SQ', '1'],
        'DeliveryTimeStructureCodeSequence' => [0x3010, 0x0088, 'SQ', '1'],
        'TreatmentSiteModifierCodeSequence' => [0x3010, 0x0089, 'SQ', '1'],
        'RoboticPathNodeSetCodeSequence' => [0x3010, 0x0091, 'SQ', '1'],
        'RoboticNodeIdentifier' => [0x3010, 0x0092, 'UL', '1'],
        'RTTreatmentSourceCoordinates' => [0x3010, 0x0093, 'FD', '3'],
        'RadiationSourceCoordinateSystemYawAngle' => [0x3010, 0x0094, 'FD', '1'],
        'RadiationSourceCoordinateSystemRollAngle' => [0x3010, 0x0095, 'FD', '1'],
        'RadiationSourceCoordinateSystemPitchAngle' => [0x3010, 0x0096, 'FD', '1'],
        'RoboticPathControlPointSequence' => [0x3010, 0x0097, 'SQ', '1'],
        'TomotherapeuticControlPointSequence' => [0x3010, 0x0098, 'SQ', '1'],
        'TomotherapeuticLeafOpenDurations' => [0x3010, 0x0099, 'FD', '1-n'],
        'TomotherapeuticLeafInitialClosedDurations' => [0x3010, 0x009a, 'FD', '1-n'],
        'ConceptualVolumeIdentificationSequence' => [0x3010, 0x00a0, 'SQ', '1'],
        'MACParametersSequence' => [0x4ffe, 0x0001, 'SQ', '1'],
        'SharedFunctionalGroupsSequence' => [0x5200, 0x9229, 'SQ', '1'],
        'PerFrameFunctionalGroupsSequence' => [0x5200, 0x9230, 'SQ', '1'],
        'WaveformSequence' => [0x5400, 0x0100, 'SQ', '1'],
        'ChannelMinimumValue' => [0x5400, 0x0110, 'ox', '1'],
        'ChannelMaximumValue' => [0x5400, 0x0112, 'ox', '1'],
        'WaveformBitsAllocated' => [0x5400, 0x1004, 'US', '1'],
        'WaveformSampleInterpretation' => [0x5400, 0x1006, 'CS', '1'],
        'WaveformPaddingValue' => [0x5400, 0x100a, 'ox', '1'],
        'WaveformData' => [0x5400, 0x1010, 'ox', '1'],
        'FirstOrderPhaseCorrectionAngle' => [0x5600, 0x0010, 'OF', '1'],
        'SpectroscopyData' => [0x5600, 0x0020, 'OF', '1'],
        'ExtendedOffsetTable' => [0x7fe0, 0x0001, 'OV', '1'],
        'ExtendedOffsetTableLengths' => [0x7fe0, 0x0002, 'OV', '1'],
        'EncapsulatedPixelDataValueTotalLength' => [0x7fe0, 0x0003, 'UV', '1'],
        'FloatPixelData' => [0x7fe0, 0x0008, 'OF', '1'],
        'DoubleFloatPixelData' => [0x7fe0, 0x0009, 'OD', '1'],
        'PixelData' => [0x7fe0, 0x0010, 'px', '1'],
        'DigitalSignaturesSequence' => [0xfffa, 0xfffa, 'SQ', '1'],
        'DataSetTrailingPadding' => [0xfffc, 0xfffc, 'OB', '1'],
        'Item' => [0xfffe, 0xe000, 'na', '1'],
        'ItemDelimitationItem' => [0xfffe, 0xe00d, 'na', '1'],
        'SequenceDelimitationItem' => [0xfffe, 0xe0dd, 'na', '1'],
    ];
}
